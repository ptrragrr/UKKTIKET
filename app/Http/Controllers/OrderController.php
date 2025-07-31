<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index()
    {
        return view('user.orders.index');
    }

    // CheckoutController.php
public function show(Request $request)
{
    return view('checkout', [
        'tickets' => json_decode($request->tickets, true),
        'subtotal' => $request->subtotal,
        'tax' => $request->tax,
        'fee' => $request->fee,
        'total' => $request->total,
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'nama_pembeli' => 'required|string|max:255',
        // Validasi lainnya
    ]);

    // Simpan transaksi
}
}
