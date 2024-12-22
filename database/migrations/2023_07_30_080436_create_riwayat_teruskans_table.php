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
        Schema::create('riwayat_teruskans', function (Blueprint $table) {
            $table->string('id_teruskan', 36)->primary();
            $table->string('id_tugas', 36);
            $table->string('nama_pengirim', 64);
            $table->string('role_pengirim', 8);

            // $table->string('tujuan', 18);
            $table->string('nama_tujuan', 64);
            $table->string('role_tujuan', 8);
            $table->enum('ket_tujuan', ['diterima', 'ditolak', 'diteruskan', 'menunggu_konfirmasi']);
            $table->timestamps();

            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_teruskans');
    }
};
