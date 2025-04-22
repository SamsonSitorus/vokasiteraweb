<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'kelompok_id',
        'ruangan',
        'waktu',
        'penguji1',
        'penguji2',
        'user_id',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function kelompok(){
        return $this->belongsTo(Kelompok::class);
    }
    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }
}
