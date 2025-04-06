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
        Schema::create('dosen_roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); // ID user dari API eksternal
            $table->unsignedBigInteger('role_id'); // Harus unsigned agar cocok dengan id di roles

            // Indexing
            $table->index('user_id');
            $table->index('role_id');

            // Foreign Key Constraint
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_roles');
    }
};
