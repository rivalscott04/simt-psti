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
            $table->string('id_tugas', 36)->primary();
            $table->string('user_id', 18);
            $table->string('nama_pengirim', 64);
            $table->string('role_pengirim', 8);
            $table->text('perihal');
            $table->time('tenggat_waktu_jam');
            $table->date('tenggat_waktu_tanggal');
            $table->text('url')->nullable();
            // $table->binary('lampiran')->nullable();
            $table->string('lampiran', 40)->nullable();
            $table->string('tujuan');
            $table->string('role_tujuan', 8);
            $table->enum('ket_tujuan', ['diterima', 'ditolak', 'diteruskan', 'menunggu_konfirmasi']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
