<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Atasan extends Authenticatable
{
    protected $table = 'atasan';
    protected $primaryKey = 'atasan_id';
    protected $fillable = ['nama', 'jabatan', 'email', 'no_hp'];
}
