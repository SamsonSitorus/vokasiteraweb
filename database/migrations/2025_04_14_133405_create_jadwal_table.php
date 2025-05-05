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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
            $table->string('ruangan',255);
            $table->dateTime('waktu');
            $table->unsignedBigInteger('user_id');
            $table->foreignId('KPA_id')->nullable()->constrained('kategori_pa')->onDelete('cascade');
            $table->foreignId('prodi_id')->nullable()->constrained('prodi')->onDelete('cascade');
            $table->foreignId('TM_id')->nullable()->constrained('tahun_masuk')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
