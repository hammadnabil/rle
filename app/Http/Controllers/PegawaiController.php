<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;

class PegawaiController extends Controller
{
   public function profil(User $user)
{
    $user = Auth::user();
    $totalIzin = $user->izin()->count();
    $izinDisetujui = $user->izin()->where('status', 'disetujui')->count();
    $izinDitolak = $user->izin()->where('status', 'ditolak')->count();

    return view('pegawai.profil', compact('user', 'totalIzin', 'izinDisetujui', 'izinDitolak'));
}


public function dashboard(Request $request)
    {
        $user = Auth::user();

        $selectedTahun = $request->input('tahun', now()->year);
        $selectedBulan = $request->input('bulan');

      
        $query = Izin::where('pegawai_id', $user->id)
            ->whereYear('created_at', $selectedTahun);

       
        if ($selectedBulan) {
            $query->whereMonth('created_at', $selectedBulan);
        }

        $totalIzin = $query->count();
        $disetujui = (clone $query)->where('status', 'disetujui')->count();
        $ditolak = (clone $query)->where('status', 'ditolak')->count();

        $bulan = [];
        $izinDisetujuiPerBulan = [];
        $izinDitolakPerBulan = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()->month($i)->translatedFormat('F');
            $izinDisetujuiPerBulan[] = Izin::where('pegawai_id', $user->id)
                ->whereYear('created_at', $selectedTahun)
                ->whereMonth('created_at', $i)
                ->where('status', 'disetujui')->count();

            $izinDitolakPerBulan[] = Izin::where('pegawai_id', $user->id)
                ->whereYear('created_at', $selectedTahun)
                ->whereMonth('created_at', $i)
                ->where('status', 'ditolak')->count();
        }

        return view('pegawai.dashboard', compact(
            'user',
            'totalIzin',
            'disetujui',
            'ditolak',
            'bulan',
            'izinDisetujuiPerBulan',
            'izinDitolakPerBulan',
            'selectedTahun',
            'selectedBulan'
        ));
    }

}
