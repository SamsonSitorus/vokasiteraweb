<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_bimbingan', function (Blueprint $table) {
            $table->bigIncrements('bimbingan_id');
            $table->string('keperluan', 255);
            $table->text('deskripsi')->nullable();
            $table->dateTime('rencana_bimbingan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelompok_id');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_bimbingan');
    }
};
