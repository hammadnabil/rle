<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';
    protected $primaryKey = 'izin_id';

    protected $fillable = [
        'pegawai_id',
        'atasan_id',
        'tanggal_pengajuan',
        'tanggal_izin',
        'alasan',
        'status',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_izin' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }
}
