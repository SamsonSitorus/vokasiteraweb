<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'request_bimbingan'; // Sesuai nama tabel di database

    protected $primaryKey = 'bimbingan_id'; // Primary key yang bukan default 'id'

    protected $fillable = [
        'keperluan',
        'deskripsi',
        'rencana_bimbingan',
        'status',
        'user_id',
        'dosen_id',
        'kelompok_id',
    ];

    // Relasi ke User (mahasiswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relasi ke Kelompok
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}
