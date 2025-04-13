<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Prodi')->insert([
            [
                'nama_prodi' => 'DIV Teknologi Rekayasa Perangkat Lunak',
                'maks_project' =>'3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_prodi' => 'DIII Teknologi Informasi',
                'maks_project' =>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_prodi' => 'DIII Teknologi Komputer',
                'maks_project' =>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
