<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets'; // pastikan nama tabel sesuai

    protected $fillable = [
        'jenis_tiket',
        'harga_tiket',
        'stok_tiket',
        'deskripsi', // tambahkan jika ada kolom deskripsi
    ];
}
