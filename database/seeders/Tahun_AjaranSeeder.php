<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tahun_AjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tahun_ajaran')->insert([
            [
                'Tahun_Ajaran' => '2024',
                'created_at' => now(),
                'updated_at' => now(),
                'Status' => 'Aktif',
            ],
            [
                'Tahun_Ajaran' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
                'Status' => 'Tidak Aktif',
            ],
        ]);
    }
}
