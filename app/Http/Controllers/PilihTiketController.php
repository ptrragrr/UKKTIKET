<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class PilihTiketController extends Controller
{
    public function index()
{
    $tickets = Ticket::with('konser')->get(); // <- eager loading relasi konser
    return view('users.tiket', compact('tickets'));
}
    // public function index()
    // {
    //     // $tickets = Ticket::with('konser')->get();
    // $tickets = Ticket::all(); // ambil data dari database
    //    return view('users.tiket', compact('tickets'));

    // }
}
