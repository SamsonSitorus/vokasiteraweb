<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'instruksi',
        'file',
        'batas',
        'user_id',
    ];

    protected $casts = [
        'batas' => 'datetime',
    ];
}
