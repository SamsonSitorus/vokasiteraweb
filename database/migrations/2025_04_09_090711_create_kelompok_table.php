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
            $table->string('nomor_kelompok', 100);
            $table->foreignId('KPA_id')->constrained('kategori_pa')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade'); // foreign key
            $table->foreignId('TA_id')->constrained('tahun_ajaran')->onDelete('cascade'); //foreign key
            $table->timestamps();
        
            $table->unique(['nomor_kelompok', 'KPA_id', 'prodi_id', 'TA_id'], 'kelompok_unique');
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
