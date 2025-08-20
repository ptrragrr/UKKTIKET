<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Konser;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        $ticketsData = json_decode($request->input('tickets'), true);

        if (!$ticketsData || count($ticketsData) === 0) {
            return redirect()->route('home')->with('error', 'Silakan pilih tiket terlebih dahulu.');
        }

        $ticketIds = array_column($ticketsData, 'id');
        $tickets = Ticket::with('konser')->whereIn('id', $ticketIds)->get();

        if ($tickets->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tiket tidak ditemukan.');
        }

        // Ambil tiket pertama
        $ticket = $tickets->first();
        $konser = $ticket->konser;
        $jumlah = $ticketsData[0]['qty'] ?? 1;
        $harga = $ticket->harga_tiket;

        $tax = $harga * $jumlah * 0.10;
        $platformFee = $harga * $jumlah * 0.05;
        $total = (int) round(($harga * $jumlah) + $tax + $platformFee);

        return view('checkout', [
            'tickets' => $tickets,
            'konser' => $konser,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'tax' => $tax,
            'platformFee' => $platformFee,
            'total' => $total,
            'ticketsData' => $ticketsData
        ]);
    }

    public function createCharge(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric|min:100',
            'detail_produk' => 'required|array|min:1',
        ]);

        $orderId = 'ORDER-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->total_harga,
            ],
            'item_details' => $request->detail_produk,
            'customer_details' => [
                'first_name' => $request->input('pengirim') ?? 'User',
                'email' => Auth::user()->email ?? 'guest@mail.com',
                'phone' => Auth::user()->phone ?? '081234567890',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error createCharge: ' . $e->getMessage(), $params);
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function pay(Request $request)
    {
        $input = $request->isJson() ? $request->json()->all() : $request->all();

        \Log::info('Data ke /pay:', $input);

        $validator = \Validator::make($input, [
            'nama_pembeli' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required',
            'konser_id' => 'required|exists:konser,id',
            'jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 422);
        }

        $data = $validator->validated();

        // ✅ Ambil tiket berdasarkan konser
        $ticket = Ticket::where('konser_id', $data['konser_id'])->firstOrFail();
        $harga = $ticket->harga_tiket;
        $jumlah = $data['jumlah'];

        $tax = $harga * $jumlah * 0.10;
        $platformFee = $harga * $jumlah * 0.05;
        $total = (int) round(($harga * $jumlah) + $tax + $platformFee);

        $orderId = 'ORDER-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => [
                [
                    'id' => $ticket->id,
                    'price' => $harga,
                    'quantity' => $jumlah,
                    'name' => $ticket->jenis_tiket,
                ],
                [
                    'id' => 'tax',
                    'price' => (int) round($tax),
                    'quantity' => 1,
                    'name' => 'Tax 10%',
                ],
                [
                    'id' => 'platform_fee',
                    'price' => (int) round($platformFee),
                    'quantity' => 1,
                    'name' => 'Platform Fee',
                ]
            ],
            'customer_details' => [
                'first_name' => $data['nama_pembeli'],
                'email' => $data['email'],
                'phone' => $data['telepon'],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error pay(): ' . $e->getMessage(), $params);
            return response()->json([
                'error' => true,
                'message' => 'Gagal mendapatkan token pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeGuest(Request $request)
    {
        // TODO: proses simpan transaksi tamu di sini
    }
}
