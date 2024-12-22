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
        Schema::create('riwayat_penerimaans', function (Blueprint $table) {
            $table->string('id_penerimaan', 36)->primary();
            $table->string('id_tugas', 36);
            $table->string('nama_pengguna', 64);
            $table->enum('keterangan', ['completed', 'incomplete']);
            $table->timestamps();

            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penerimaans');
    }
};
