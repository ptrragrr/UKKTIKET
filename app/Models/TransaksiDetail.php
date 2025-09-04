<?php
// app/Models/TransaksiDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_details'; // nama tabel kamu
    protected $fillable = [
        'transaksi_id',
        'ticket_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
