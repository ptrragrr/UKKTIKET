<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Ticket;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Mail\TicketPaidMail;

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
        $ticketsData = $request->input('tickets', session('cart', []));
        if (is_string($ticketsData)) {
            $ticketsData = json_decode($ticketsData, true);
        }

        if (empty($ticketsData) || !is_array($ticketsData)) {
            return redirect()->route('home')->with('error', 'Silakan pilih tiket terlebih dahulu.');
        }

        $normalized = [];
        foreach ($ticketsData as $row) {
            $id = $row['id'] ?? $row['ticket_id'] ?? null;
            $qty = $row['qty'] ?? $row['jumlah'] ?? 1;
            if ($id) {
                $normalized[] = ['id' => (int)$id, 'qty' => max(1, (int)$qty)];
            }
        }

        if (empty($normalized)) {
            return redirect()->route('home')->with('error', 'Tidak ada tiket valid yang dipilih.');
        }

        $ids = array_unique(array_column($normalized, 'id'));
        $tickets = Ticket::whereIn('id', $ids)->get()->keyBy('id');

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
        ]);

        $ticketIds = array_unique(array_map(fn($t) => (int)$t['id'], $payload['tickets']));
        $tickets = Ticket::whereIn('id', $ticketIds)->get()->keyBy('id');

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
                'name' => "{$ticket->nama_event} - {$ticket->jenis_tiket}" // ✅ pakai field langsung
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
                'callbacks' => [
                    'finish' => route('checkout.callback')
                ]
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
            Log::error('pay error: '.$e->getMessage());
            return response()->json(['error' => true, 'message' => 'Gagal membuat transaksi.'], 500);
        }
    }

    /**
     * Callback dari frontend setelah pembayaran
     */
    public function callback(Request $request)
    {
        $orderId = $request->input('order_id');
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'Order ID tidak ditemukan.');
        }

        try {
            $status = Transaction::status($orderId);
            $this->updateTransactionStatus($orderId, $status->transaction_status, $status->gross_amount);

            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                return redirect()->route('checkout.success', ['order_id' => $orderId]);
            } else {
                return redirect()->route('checkout.failed', ['order_id' => $orderId]);
            }

        } catch (\Exception $e) {
            Log::error('Callback error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    /**
     * Webhook dari Midtrans
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $notification = json_decode($payload, true);

            Log::info('Midtrans webhook received', $notification);

            if (!isset($notification['order_id']) || !isset($notification['transaction_status'])) {
                return response()->json(['message' => 'Invalid notification'], 400);
            }

            $serverKey = Config::$serverKey;
            $hashed = hash('sha512', $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . $serverKey);

            if ($hashed !== $notification['signature_key']) {
                return response()->json(['message' => 'Invalid signature'], 401);
            }

            $this->updateTransactionStatus(
                $notification['order_id'],
                $notification['transaction_status'],
                $notification['gross_amount']
            );

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    /**
     * Update status transaksi
     */
    private function updateTransactionStatus($orderId, $status, $amount = null)
    {
        $transaksi = Transaksi::where('kode_transaksi', $orderId)->first();

        if (!$transaksi) {
            Log::warning("Transaksi tidak ditemukan: {$orderId}");
            return;
        }

        $statusMap = [
            'pending' => 'pending',
            'settlement' => 'paid',
            'capture' => 'paid',
            'cancel' => 'cancelled',
            'deny' => 'cancelled',
            'failure' => 'cancelled',
            'expire' => 'cancelled',
        ];

        $newStatus = $statusMap[strtolower($status)] ?? $status;

        $updateData = ['status_payment' => $newStatus];
        if ($amount) {
            $updateData['bayar'] = $amount;
        }

        $previousStatus = $transaksi->status_payment;
        $transaksi->update($updateData);

        if ($newStatus === 'paid' && $previousStatus !== 'paid') {
            foreach ($transaksi->details as $detail) {
                $ticket = Ticket::find($detail->ticket_id);
                if ($ticket && $ticket->stok_tiket >= $detail->jumlah) {
                    $ticket->decrement('stok_tiket', $detail->jumlah);
                }
            }

            try {
                Mail::to($transaksi->email)->send(new TicketPaidMail($transaksi));
                Log::info("Email tiket berhasil dikirim ke {$transaksi->email}");
            } catch (\Exception $e) {
                Log::error("Gagal kirim email ke {$transaksi->email}: " . $e->getMessage());
            }
        }

        Log::info("Status transaksi {$orderId} diubah menjadi {$newStatus}");
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string',
            'bayar' => 'nullable|numeric'
        ]);

        $this->updateTransactionStatus(
            $request->order_id,
            $request->status,
            $request->bayar
        );

        return response()->json(['success' => true]);
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaksi = Transaksi::where('kode_transaksi', $orderId)->first();

        if (!$transaksi) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        foreach ($transaksi->details as $detail) {
            if (!$detail->kode_tiket) {
                $detail->kode_tiket = strtoupper(Str::random(8));
                $detail->save();
            }
        }

        try {
            Mail::to($transaksi->email)->send(
                new \App\Mail\TicketPaidMail($transaksi)
            );
            Log::info("Email tiket berhasil dikirim ke {$transaksi->email}");
        } catch (\Exception $e) {
            Log::error("Gagal kirim email ke {$transaksi->email}: " . $e->getMessage());
        }

        return view('checkout.success', compact('transaksi'));
    }

    public function failed(Request $request)
    {
        $orderId = $request->get('order_id');
        $transaksi = Transaksi::where('kode_transaksi', $orderId)->first();

        return view('checkout.failed', compact('transaksi', 'orderId'));
    }

    public function checkStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            $this->updateTransactionStatus($orderId, $status->transaction_status, $status->gross_amount);

            $transaksi = Transaksi::where('kode_transaksi', $orderId)->first();

            return response()->json([
                'status' => $transaksi->status_payment,
                'transaction_status' => $status->transaction_status,
                'amount' => $status->gross_amount
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function testUpdateStatus($orderId, $status = 'paid')
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        $this->updateTransactionStatus($orderId, $status);

        return response()->json([
            'message' => "Status transaksi {$orderId} berhasil diubah menjadi {$status}"
        ]);
    }

    public function showTiket($id)
    {
        $transaksi = \App\Models\Transaksi::with('detailTransaksi.ticket')->findOrFail($id);

        return view('tiket.show', compact('transaksi'));
    }
}