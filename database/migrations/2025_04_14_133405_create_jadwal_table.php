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
            $table->unsignedBigInteger('penguji1');
            $table->unsignedBigInteger('penguji2');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('penguji1');
            $table->index('penguji2');
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
