<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
        });
    }

    public function down()
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai']);
        });
    }

};
