<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class PilihTiketController extends Controller
{
    public function index()
    {
        // Ambil data tiket terbaru (desc)
        $tickets = Ticket::orderBy('id', 'desc')->get();

        // Kirim ke view users/tiket.blade.php
        return view('users.tiket', compact('tickets'));
    }
}
