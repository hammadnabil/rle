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
            $table->id('izin_id'); // Primary key
            $table->unsignedBigInteger('pegawai_id'); // Foreign key ke tabel users
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_izin');
            $table->string('alasan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('alasan_ditolak')->nullable();
            $table->date('tanggal_persetujuan')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('pegawai_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
