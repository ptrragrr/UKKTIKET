<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class CheckoutController extends Controller
{
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

    // ✅ Ambil tiket dan konser pertama
    $ticket = $tickets->first();
    $konser = $ticket->konser;

    // ✅ Hitung ulang jumlah, harga, pajak, fee, total
    $jumlah = $ticketsData[0]['qty'] ?? 1; // default 1 jika tidak ada
    $harga = $ticket->harga_tiket;

    $tax = $harga * $jumlah * 0.10;
    $platformFee = $harga * $jumlah * 0.05;
    $total = ($harga * $jumlah) + $tax + $platformFee;

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

    public function storeGuest(Request $request)
    {
        // proses simpan transaksi tamu
    }
}
