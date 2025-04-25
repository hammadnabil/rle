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
        Schema::create('atasan', function (Blueprint $table) {
            $table->id('atasan_id');
            $table->string('nama');
            $table->enum('jabatan', ['TU', 'Manajer']);
            $table->string('email')->unique();
            $table->integer('no_hp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atasan');
    }
};
