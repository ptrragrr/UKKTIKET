<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Konser;


class Ticket extends Model
{
    protected $table = 'tickets'; // pastikan nama tabel sesuai

    protected $fillable = [
        'konser_id', 'jenis_tiket', 'harga_tiket', 'stok_tiket',
    ];

    public function konser()
    {
        return $this->belongsTo(Konser::class);
    }
}
