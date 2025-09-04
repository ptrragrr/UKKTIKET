<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {   
        // buat kode unik untuk transaksi
        $orderId = 'TRX-' . Str::uuid();
        $amount = $request->total_harga;

        // simpan transaksi ke DB dengan status pending
        $transaksi = Transaksi::create([
            'user_id' => auth()->id() ?? null,
            'kode_transaksi' => $orderId,
            'metode_pembayaran' => 'midtrans',
            'total_harga' => $amount,
            'bayar' => 0,
            'status' => 'pending',
        ]);

        // konfigurasi midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // ganti true kalau sudah live
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $request->nama ?? 'Guest',
                'email' => $request->email ?? 'guest@example.com',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'transaksi' => $transaksi
        ]);
    }

    public function notificationHandler(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');

        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $transaksi = Transaksi::where('kode_transaksi', $order_id)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $transaksi->status = 'pending';
            } else {
                $transaksi->status = 'paid';
            }
        } else if ($transaction == 'settlement') {
            $transaksi->status = 'paid';
        } else if ($transaction == 'pending') {
            $transaksi->status = 'pending';
        } else if (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $transaksi->status = 'cancelled';
        }

        $transaksi->save();

        return response()->json(['message' => 'Notifikasi berhasil diproses']);
    }
}
