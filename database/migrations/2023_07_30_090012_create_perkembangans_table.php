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
        Schema::create('perkembangans', function (Blueprint $table) {
            $table->string('id_perkembangan', 36)->primary();
            $table->string('id_tugas', 36);
            $table->text('todo_list');
            $table->enum('keterangan', ['completed', 'incomplete', 'menunggu_konfirmasi', 'revisi']);
            $table->json('pihak_terlibat')->nullable();
            $table->text('url')->nullable();
            $table->string('lampiran', 40)->nullable();
            $table->string('nama_pengguna', 64);
            $table->text('alasan_revisi')->nullable();
            $table->timestamps();

            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangans');
    }
};
