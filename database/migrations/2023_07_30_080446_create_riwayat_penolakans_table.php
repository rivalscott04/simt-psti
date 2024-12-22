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
        Schema::create('riwayat_penolakans', function (Blueprint $table) {
            $table->string('id_penolakan', 36)->primary();
            $table->string('id_tugas', 36);
            $table->string('nama_pengguna', 64);
            $table->text('alasan_penolakan');
            $table->timestamps();

            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penolakans');
    }
};
