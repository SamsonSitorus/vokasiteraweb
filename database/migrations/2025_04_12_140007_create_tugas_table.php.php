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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul',255) ;
            $table->string('instruksi');
            $table->string('file')->nullable();
            $table->datetime('batas');
            $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->index('user_id');
            // $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema :: dropIfExists('tugas');
    }
};
