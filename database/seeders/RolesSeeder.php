<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'koordinator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'penguji 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'pembimbing 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'penguji 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'pembimbing 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
