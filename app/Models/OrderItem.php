<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
   protected $fillable = ['order_id', 'ticket_type', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
