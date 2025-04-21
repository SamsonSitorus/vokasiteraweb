<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'user_id',
        'Judul_Tugas',
        'Deskripsi_Tugas',
        'KPA_id',
        'prodi_id',
        'TA_id',
        'tanggal_pengumpulan',
        'file',
        'status',
    ];

    protected $casts = [
        'tanggal_pengumpulan' => 'datetime',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'TA_id');
    }
    public function kategoriPA()
    {
        return $this->belongsTo(KategoriPA::class, 'KPA_id');
    }
    public function pengumpulan(){
        return $this->hasMany(pengumpulan_tugas::class);
    }
}
