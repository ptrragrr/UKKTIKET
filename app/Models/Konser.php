<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Konser extends Model
{
    protected $table = 'konser';
    protected $guarded = []; // supaya mass assignment bisa dilakukan

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
