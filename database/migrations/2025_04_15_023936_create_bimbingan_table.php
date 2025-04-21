<?php

use App\Models\Kelompok;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_bimbingan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('keperluan');
            $table->dateTime('rencana_mulai');
            $table->dateTime('rencana_selesai');
            $table->string('lokasi');
            $table->enum('status', ['menunggu', 'selesai', 'disetujui','ditolak']);
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('request_bimbingan');
    }
};
