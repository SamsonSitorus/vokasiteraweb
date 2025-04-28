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
        'KPA_id',
        'prodi_id',
        'TA_id'
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function kelompok(){
        return $this->belongsTo(Kelompok::class);
    }

    public function kategoriPA()
    {
        return $this->belongsTo(KategoriPA::class, 'KPA_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'TA_id');
    }
}
