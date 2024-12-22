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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 18);
            $table->string('id_prodi', 18);
            $table->string('nama_pengguna', 64);
            $table->string('password', 64);
            
            $table->rememberToken();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};