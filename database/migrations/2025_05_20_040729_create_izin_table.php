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
        Schema::create('izin', function (Blueprint $table) {
            $table->id('izin_id');
            $table->foreignId('pegawai_id')->references('id')->on('users');
            $table->foreignId('atasan_id')->references('id')->on('users');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_izin');
            $table->string('alasan');
            $table->enum('status' , ['menunggu','disetujui','ditolak']);
            $table->timestamp('tanggal-persetujuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
