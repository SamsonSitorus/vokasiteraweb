<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSeminar extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_seminar';

    protected $fillable = [
        'kelompok_id',
        'pembimbing_id',
        'status',
        'catatan',
    ];    
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
    
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }
    
    public function files()
    {
        return $this->hasMany(PengajuanSeminarFile::class, 'pengajuan_seminar_id');
    }
}

//🔎 Artinya: 1 pengajuan seminar bisa punya banyak file (1:N).
    
