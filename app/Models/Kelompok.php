<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nilai_kelompok;
class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
    public function tahunMasuk()
{
    return $this->belongsTo(tahunMasuk::class, 'TM_id');
}
    public function kategoriPA()
    {
        return $this->belongsTo(KategoriPA::class, 'KPA_id');
    }
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }
    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'kelompok_id');
    }
    public function nilais()
    {
        return $this->hasMany(Nilai_kelompok::class);
    }   
    public function nilaiindividu()
    {
        return $this->hasMany(Nilai_Individu::class);
    }  
    public function penguji()
    {
        return $this->hasMany(Penguji::class, 'kelompok_id');
    }
    public function KelompokMahasiswa() {
        return $this->hasMany(KelompokMahasiswa::class);
    }
    protected $fillable = [
        'nomor_kelompok',
        'KPA_id',
        'prodi_id',
        'TM_id',
    ];
}
