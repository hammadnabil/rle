<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom id
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_wa')->nullable(); // Bisa null jika tidak wajib
            $table->unsignedInteger('umur')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable(); // L = Laki-laki, P = Perempuan
            $table->string('password');
            $table->string('jabatan'); // Contoh: 'pegawai' atau 'atasan'
            $table->rememberToken();
            $table->string('fonnte_token')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}