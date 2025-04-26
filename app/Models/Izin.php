<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function atasan()
    {
        return $this->belongsTo(Atasan::class, 'atasan_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
