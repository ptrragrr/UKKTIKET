<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konser extends Model
{
    protected $table = 'konser';
    protected $guarded = []; // supaya mass assignment bisa dilakukan
}
