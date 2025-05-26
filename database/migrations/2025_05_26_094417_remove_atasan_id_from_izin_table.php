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
        $table->dropForeign(['atasan_id']);
        $table->dropColumn('atasan_id');
    });
}

public function down()
{
    Schema::table('izin', function (Blueprint $table) {
        $table->unsignedBigInteger('atasan_id')->nullable();
        $table->foreign('atasan_id')->references('id')->on('users')->onDelete('set null');
    });
}

};
