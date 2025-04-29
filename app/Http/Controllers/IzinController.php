<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Atasan;
use Illuminate\Support\Facades\Auth;
use App\Mail\StatusIzinMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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


        Mail::to($izin->pegawai->email)->send(new StatusIzinMail($izin));

        return redirect()->route('atasan.pengajuan')->with('success', 'Pengajuan izin berhasil diproses dan email telah dikirim.');
    }


    public function historiIzin(Request $request)
    {
        $query = Izin::query();

        // Filter berdasarkan nama pegawai
        if ($request->filled('nama')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        $tahun = $request->tahun ?? now()->year; // Default ke tahun sekarang kalau tidak dipilih

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pengajuan', $request->bulan)
                ->whereYear('tanggal_pengajuan', $tahun);
        }

        // Filter berdasarkan minggu
        if ($request->filled('minggu')) {
            $bulan = $request->bulan ?? now()->month; // Kalau bulan kosong, default bulan sekarang

            $startOfMonth = Carbon::create($tahun, $bulan, 1);

            $startOfWeek = $startOfMonth->copy()->addWeeks($request->minggu - 1)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

            $query->whereBetween('tanggal_pengajuan', [$startOfWeek, $endOfWeek]);
        }

        $histori = $query->whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('atasan.histori', compact('histori'));
    }


    public function loadPegawai(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $pegawai = DB::table('pegawai')
                ->select('nama as id', 'nama as text')
                ->where('nama', 'like', '%' . $search . '%')
                ->limit(10)
                ->get();

            return response()->json($pegawai);
        }
        return response()->json([]);
    }

    public function exportPDF(Request $request)
    {
        $namaBulan = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];
    
        $query = Izin::query();
    
        // Handle filter nama pegawai
        if ($request->filled('nama')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }
    
        $bulanInput = $request->bulan ?? null;
        $tahun = $request->tahun ?? now()->year;
    
        // Konversi nama bulan ke angka kalau perlu
        if ($bulanInput && !is_numeric($bulanInput)) {
            $bulan = $namaBulan[$bulanInput] ?? null;
        } else {
            $bulan = $bulanInput;
        }
    
        // Filter bulan & tahun
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan)
                  ->whereYear('tanggal_pengajuan', $tahun);
        }
    
        // Filter minggu
        if ($request->filled('minggu')) {
            $bulanUntukMinggu = $bulan ?? now()->month;
            $startOfMonth = Carbon::createFromDate($tahun, $bulanUntukMinggu, 1);
            $startOfWeek = $startOfMonth->copy()->addWeeks($request->minggu - 1)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
            $query->whereBetween('tanggal_pengajuan', [$startOfWeek, $endOfWeek]);
        }
    
        // Ambil datanya
        $histori = $query->whereIn('status', ['disetujui', 'ditolak'])
                        ->orderBy('tanggal_pengajuan', 'desc')
                        ->get();
    
        // Siapkan data untuk PDF
        $bulanTeks = 'Semua Bulan';
        if ($bulan) {
            $bulanTeks = array_search($bulan, $namaBulan) ?: 'Semua Bulan';
        }
    
        $mingguTeks = $request->filled('minggu') ? 'Minggu ke-' . $request->minggu : 'Semua Minggu';
        $tahunTeks = $request->filled('tahun') ? $request->tahun : 'Semua Tahun';
        $namaTeks = $request->filled('nama') ? $request->nama : 'Semua Pegawai';
    
        // Buat PDF
        $pdf = Pdf::loadView('pdf.histori-izin', [
            'histori' => $histori,
            'bulan' => $bulanTeks,
            'minggu' => $mingguTeks,
            'tahun' => $tahunTeks,
            'nama' => $namaTeks,
        ])->setPaper('a4', 'landscape');
    
        return $pdf->download('histori-izin.pdf');
    }
    
}
