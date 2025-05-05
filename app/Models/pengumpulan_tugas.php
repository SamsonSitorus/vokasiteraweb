<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengumpulan_tugas extends Model
{
    use HasFactory;
    protected $table = 'pengumpulan_tugas';
    protected $fillable = [
        'kelompok_id',
        'tugas_id',
        'waktu_submit',
        'file_path',
        'status',
        'feedback',
        'feedback_pembimbing'
    ];
    public function Kelompok()
    {
        return $this->belongsTo(Kelompok::class,'kelompok_id');
    }
    public function tugas()
    {
        return $this->belongsTo(Tugas::class,'tugas_id');
    }
    public function pembimbing(){
        return $this->belongsTo(pembimbing::class);
    }
}
