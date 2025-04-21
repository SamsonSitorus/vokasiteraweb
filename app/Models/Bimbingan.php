<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'request_bimbingan'; // Sesuai nama tabel di database
    protected $fillable = [
        'kelompok_id',
        'user_id',
        'keperluan',
        'rencana_mulai',
        'rencana_selesai',
        'lokasi',
        'status',
    ];
    // Relasi ke Kelompok
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}
