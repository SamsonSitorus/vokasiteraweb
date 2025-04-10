<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosenRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama_dosen',
        'role_id',
        'nama_role',
        'prodi',
        'jenis_pa',
    ];
    
}
