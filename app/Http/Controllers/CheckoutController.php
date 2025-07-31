<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return view('checkout'); // Buat view checkout.blade.php
    }

    public function storeGuest(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'nama_pembeli' => 'required|string|max:255',
        'email' => 'required|email',
        'konser_id' => 'required|exists:konser,id',
        'jumlah' => 'required|integer|min:1',
        'metode_pembayaran' => 'required|string',
    ]);

    // Simpan data ke tabel transaksi (atau yang sesuai)
    $transaksi = \App\Models\Transaksi::create([
        'nama_pembeli' => $validated['nama_pembeli'],
        'email' => $validated['email'],
        'konser_id' => $validated['konser_id'],
        'jumlah' => $validated['jumlah'],
        'metode_pembayaran' => $validated['metode_pembayaran'],
        'status' => 'pending',
    ]);

    // Redirect atau tampilkan view konfirmasi
    return redirect()->route('transaksi.success')->with('success', 'Pembayaran berhasil diproses!');
}
}
