<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $fillable = [
         'Tahun_Ajaran',
         'Status',
    ];
    protected $table = 'tahun_ajaran';
    public function dosenRoles()
    {
        return $this->hasMany(DosenRole::class);
    }
    public function Kelompok()
    {
        return $this->hasMany(Kelompok::class);
    }
}
