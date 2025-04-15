<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika berbeda dari nama model
    protected $table = 'pengumuman';

    // Menentukan primary key tabel
    protected $primaryKey = 'pengumuman_id';

    // Menentukan kolom yang dapat diisi mass-assignment
    protected $fillable = [
        'judul', 
        'pengirim', 
        'deskripsi', 
        'status', 
        'user_id',
        'created_at',
    ];

    // Menentukan apakah kolom timestamp otomatis diatur oleh Eloquent
    public $timestamps = true;

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}