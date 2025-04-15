<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa tabelnya bernama 'kelompok'
    protected $table = 'kelompok';

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
    protected $fillable = [
        'nomor_kelompok',
        'KPA_id',
        'prodi_id',
        'TA_id',
        'status',
    ];
}
