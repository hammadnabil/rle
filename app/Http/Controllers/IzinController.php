<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Atasan;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class IzinController extends Controller
{
    public function index()
    {
        $atasans = Atasan::all(); // semua atasan untuk dipilih
        return view('pegawai.izin', compact('atasans'));
    }

    public function store(Request $request)
{
    $pegawaiId = Auth::guard('pegawai')->id(); // Gunakan guard pegawai
    if (!$pegawaiId) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    $request->validate([
        'atasan_id' => 'required|exists:atasan,atasan_id',
        'tanggal_izin' => 'required|date|after_or_equal:today',
        'alasan' => 'required|string|max:255',
    ]);

    Izin::create([
        'pegawai_id' => $pegawaiId,
        'atasan_id' => $request->atasan_id,
        'tanggal_pengajuan' => now(),
        'tanggal_izin' => $request->tanggal_izin,
        'alasan' => $request->alasan,
        'status' => 'Menunggu',
    ]);

    return redirect()->route('izin.index')->with('success', 'Pengajuan izin berhasil dikirim.');
}

    

    public function pengajuanIzin()
    {
        $pengajuan = Izin::where('status', 'menunggu')->get(); // Mengambil pengajuan yang statusnya 'menunggu'
        return view('atasan.pengajuan', compact('pengajuan'));
    }

   
    public function setujuiTolak(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        $izin->status = $request->status; // Mengubah status menjadi disetujui atau ditolak
        $izin->save();

        // Kirim notifikasi ke pegawai
        Notifikasi::create([
            'izin_id' => $izin->izin_id,
            'waktu_kirim' => now(),
            'status_kirim' => 'berhasil', // atau 'gagal' jika ada masalah
        ]);

        return redirect()->route('atasan.pengajuan')->with('success', 'Pengajuan izin berhasil diproses.');
    }
}
