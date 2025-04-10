<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa tabelnya bernama 'kelompok'
    protected $table = 'kelompok';

    protected $fillable = [
        'nomor',
        'angkatan',
        'prodi',
        'jenis_pa',
    ];
}
