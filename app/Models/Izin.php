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
        'tanggal_pengajuan',
        'tanggal_izin',
        'alasan',
        'status',
        'jam_mulai',
        'jam_selesai',
        'alasan_ditolak'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_izin' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    
}
