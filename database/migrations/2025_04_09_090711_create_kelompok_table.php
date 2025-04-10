<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 100);
            $table->string('jenis_pa', 10); // e.g. PA-1, PA-2, PA-3
            $table->integer('angkatan');
            $table->string('prodi', 100); // gunakan lowercase agar konsisten
            $table->timestamps();
        
            // Unique constraint untuk kombinasi 4 kolom
            $table->unique(['nomor', 'jenis_pa', 'prodi', 'angkatan'], 'kelompok_unique');
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok');
    }
};
