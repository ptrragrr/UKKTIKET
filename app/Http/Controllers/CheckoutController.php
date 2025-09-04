<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized  = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds        = (bool) config('midtrans.is_3ds', true);
    }

    /**
     * Halaman checkout
     */
    public function index(Request $request)
    {
        // Ambil tiket dari request atau session
        $ticketsData = $request->input('tickets', session('cart', []));
        if (is_string($ticketsData)) {
            $ticketsData = json_decode($ticketsData, true);
        }

        if (empty($ticketsData) || !is_array($ticketsData)) {
            return redirect()->route('home')->with('error', 'Silakan pilih tiket terlebih dahulu.');
        }

        // Normalisasi data tickets
        $normalized = [];
        foreach ($ticketsData as $row) {
            $id = $row['id'] ?? $row['ticket_id'] ?? $row['konser_id'] ?? null;
            $qty = $row['qty'] ?? $row['jumlah'] ?? 1;
            if ($id) {
                $normalized[] = ['id' => (int)$id, 'qty' => max(1, (int)$qty)];
            }
        }

        if (empty($normalized)) {
            return redirect()->route('home')->with('error', 'Tidak ada tiket valid yang dipilih.');
        }

        // Ambil tiket dari DB
        $ids = array_unique(array_column($normalized, 'id'));
        $tickets = Ticket::with('konser')->whereIn('id', $ids)->get()->keyBy('id');

        $keranjang = [];
        $subtotal = 0;

        foreach ($normalized as $row) {
            if (!isset($tickets[$row['id']])) continue;
            $ticket = $tickets[$row['id']];
            $qty = $row['qty'];

            if ($ticket->stok_tiket < $qty) {
                return redirect()->back()->with('error', "Stok tiket untuk {$ticket->jenis_tiket} tidak mencukupi.");
            }

            $price = (int) $ticket->harga_tiket;
            $lineTotal = $price * $qty;

            $keranjang[] = [
                'ticket' => $ticket,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
            $subtotal += $lineTotal;
        }

        $tax = (int) round($subtotal * 0.10);
        $platformFee = (int) round($subtotal * 0.05);
        $total = $subtotal + $tax + $platformFee;

        return view('checkout', compact('keranjang', 'subtotal', 'tax', 'platformFee', 'total'));
    }

    /**
     * Proses pembayaran ke Midtrans
     */
    public function pay(Request $request)
    {
        $payload = $request->validate([
            'nama_pembeli' => 'required|string|max:150',
            'email' => 'required|email',
            'telepon' => 'required|string',
            'tickets' => 'required|array|min:1',
            'tickets.*.id' => 'required|integer|exists:tickets,id',
            'tickets.*.qty' => 'required|integer|min:1',
            'metode_pembayaran' => 'nullable|string',
        ]);

        // Ambil tiket dari DB
        $ticketIds = array_unique(array_map(fn($t) => (int)$t['id'], $payload['tickets']));
        $tickets = Ticket::with('konser')->whereIn('id', $ticketIds)->get()->keyBy('id');

        $itemDetails = [];
        $subtotal = 0;

        foreach ($payload['tickets'] as $t) {
            $id = (int) $t['id'];
            $qty = (int) $t['qty'];
            if (!$tickets->has($id)) continue;

            $ticket = $tickets[$id];
            if ($ticket->stok_tiket < $qty) {
                return response()->json(['error' => true, 'message' => "Stok untuk {$ticket->jenis_tiket} tidak mencukupi."], 422);
            }

            $price = (int) $ticket->harga_tiket;
            $lineTotal = $price * $qty;
            $subtotal += $lineTotal;

            $itemDetails[] = [
                'id' => (string)$ticket->id,
                'price' => $price,
                'quantity' => $qty,
                'name' => "{$ticket->konser->nama_konser} - {$ticket->jenis_tiket}"
            ];
        }

        if (empty($itemDetails)) {
            return response()->json(['error' => true, 'message' => 'Tidak ada tiket valid.'], 422);
        }

        $tax = (int) round($subtotal * 0.10);
        $platformFee = (int) round($subtotal * 0.05);
        $grandTotal = $subtotal + $tax + $platformFee;

        if ($tax > 0) {
            $itemDetails[] = [
                'id' => 'tax',
                'price' => $tax,
                'quantity' => 1,
                'name' => 'Tax 10%'
            ];
        }
        if ($platformFee > 0) {
            $itemDetails[] = [
                'id' => 'platform_fee',
                'price' => $platformFee,
                'quantity' => 1,
                'name' => 'Platform Fee'
            ];
        }

        DB::beginTransaction();
        try {
            $orderId = 'ORDER-' . strtoupper(Str::random(10));

            $transaksi = Transaksi::create([
                'nama_pembeli' => $request->nama_pembeli,
                'email' => $request->email,
                'nomer_telpon' => $request->telepon,
                'kode_transaksi' => $orderId,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'midtrans',
                'total_harga' => $grandTotal,
                'status_payment' => 'pending',
            ]);

            foreach ($payload['tickets'] as $t) {
                $ticket = $tickets[$t['id']];
                $price = (int) $ticket->harga_tiket;
                $totalLine = $price * $t['qty'];

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'ticket_id' => $ticket->id,
                    'jumlah' => $t['qty'],
                    'harga_satuan' => $price,
                    'total_harga' => $totalLine,
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grandTotal,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $payload['nama_pembeli'],
                    'email' => $payload['email'],
                    'phone' => $payload['telepon'],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'token' => $snapToken,
                'order_id' => $orderId,
                'amount' => $grandTotal
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('pay error: '.$e->getMessage());
            return response()->json(['error' => true, 'message' => 'Gagal membuat transaksi.'], 500);
        }
    }

    /**
     * Update status transaksi (webhook / frontend callback)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string',
            'bayar' => 'nullable|numeric'
        ]);

        $transaksi = Transaksi::where('kode_transaksi', $request->order_id)->first();
        if (!$transaksi) {
            return response()->json(['error' => true, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $map = [
            'pending' => 'pending',
            'settlement' => 'paid',
            'capture' => 'paid',
            'cancel' => 'cancelled',
            'deny' => 'cancelled',
            'failure' => 'cancelled',
            'expire' => 'cancelled',
            'paid' => 'paid'
        ];

        $status = strtolower($request->status);
        $to = $map[$status] ?? $status;

        $transaksi->update([
            'status' => $to,
            'bayar' => $request->input('bayar', $transaksi->bayar)
        ]);

        if ($to === 'paid') {
            foreach ($transaksi->details as $d) {
                $t = Ticket::find($d->ticket_id);
                if ($t) $t->decrement('stok_tiket', $d->qty);
            }
        }

        return response()->json(['success' => true]);
    }
}
