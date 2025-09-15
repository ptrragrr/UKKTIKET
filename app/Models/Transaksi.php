<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'nama_pembeli',
        'email',
        'nomer_telpon',
        'kode_transaksi',
        'total_harga',
        'status_payment',
        'kode_tiket',
    ];

    // 🔁 Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔁 Relasi ke detail transaksi (jika ada)
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
