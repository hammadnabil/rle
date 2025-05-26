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
    Schema::table('users', function (Blueprint $table) {
        $table->string('no_wa')->nullable()->after('email');
        $table->integer('umur')->nullable()->after('no_wa');
        $table->date('tanggal_bergabung')->nullable()->after('umur');
        $table->enum('gender', ['L', 'P'])->nullable()->after('tanggal_bergabung'); // L: Laki-laki, P: Perempuan
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['no_wa', 'umur', 'tanggal_bergabung', 'gender']);
    });
}

};
