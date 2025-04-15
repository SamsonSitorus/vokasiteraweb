<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'tangal',
        'ruangan',
        'jam',
        'user_id'
    ];

    protected $casts = [
        'batas'=>'datetime',
    ];
}
