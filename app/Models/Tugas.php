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
        // 'role_id'
    ];

    protected $casts = [
        'batas' => 'datetime',
    ];
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }
}
