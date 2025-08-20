<?php

namespace  App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'metode_pembayaran',
        'total_harga',
        'bayar',
        'status',
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
