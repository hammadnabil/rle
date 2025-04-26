<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Atasan;
use Illuminate\Support\Facades\Auth;
use App\Mail\StatusIzinMail;
use Illuminate\Support\Facades\Mail;

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
    $izin->status = $request->status;
    $izin->save();

    // Kirim email ke pegawai
    Mail::to($izin->pegawai->email)->send(new StatusIzinMail($izin));

    return redirect()->route('atasan.pengajuan')->with('success', 'Pengajuan izin berhasil diproses dan email telah dikirim.');
}
}
