<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Izin;
use Carbon\Carbon;

class AtasanController extends Controller
{
    public function listUser()
    {
        $users = User::orderBy('name')->paginate(10);

        return view('atasan.user.index', compact('users'));
    }

    public function detailUser(User $user)
{
    $totalIzin = $user->izin()->count();
    $izinDisetujui = $user->izin()->where('status', 'disetujui')->count();
    $izinDitolak = $user->izin()->where('status', 'ditolak')->count();

    return view('atasan.user.detail', compact('user', 'totalIzin', 'izinDisetujui', 'izinDitolak'));
}


    public function autocomplete(Request $request)
{
    if ($request->has('q')) {
        $search = $request->q;

        $users = User::select('id', 'name as text')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    return response()->json([]);
}

   public function profil()
{
    $user = Auth::user();
    return view('atasan.profil', compact('user'));
}

public function dashboard(Request $request)
{
    $user = Auth::user();

    $selectedTahun = $request->input('tahun', now()->year);
    $selectedBulan = $request->input('bulan');

    $query = Izin::whereYear('created_at', $selectedTahun);

    
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
        $izinDisetujuiPerBulan[] = Izin::whereYear('created_at', $selectedTahun)
            ->whereMonth('created_at', $i)
            ->where('status', 'disetujui')->count();

        $izinDitolakPerBulan[] = Izin::whereYear('created_at', $selectedTahun)
            ->whereMonth('created_at', $i)
            ->where('status', 'ditolak')->count();
    }

    return view('atasan.dashboard', compact(
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
