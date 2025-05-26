<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    protected $table = 'pegawai';
    protected $primaryKey = 'pegawai_id';
    protected $fillable = ['name', 'email', 'no_hp', 'jenis_lembaga'];
}
