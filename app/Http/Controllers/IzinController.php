<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\StatusIzinMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\FonnteService;
use App\Services\WablasNotificationService;
use Illuminate\Support\Facades\Log;

class IzinController extends Controller
{

   public function index()
{
    $user = Auth::user();

    if (!$user || $user->jabatan === 'Tata Usaha') {
        abort(403, 'Akses hanya untuk pegawai.');
    }

    return view('pegawai.izin');
}



    public function store(Request $request)
{
    $pegawaiId = Auth::id();
    $user = Auth::user();

  
    if (!$pegawaiId || $user->jabatan === 'Tata Usaha') {
        return redirect()->route('login')->with('error', 'Tata usaha tidak diperbolehkan mengajukan izin.');
    }

    $request->validate([
        'tanggal_izin' => 'required|date|after_or_equal:today',
        'alasan' => 'required|string|max:255',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ]);

    Izin::create([
        'pegawai_id' => $pegawaiId,
        'tanggal_pengajuan' => now(),
        'tanggal_izin' => $request->tanggal_izin,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'alasan' => $request->alasan,
        'status' => 'Menunggu',
    ]);

    return redirect()->route('izin.index')->with('success', 'Pengajuan izin berhasil dikirim.');
}



    public function testSendWhatsAppMessage($phone, $message)
{
    return $this->sendWhatsAppMessage($phone, $message);
}

    public function pengajuanIzin()
    {
        $pengajuan = Izin::where('status', 'menunggu')->get();
        return view('atasan.pengajuan', compact('pengajuan'));
    }

   public function setujuiTolak(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:disetujui,ditolak',
        'alasan_ditolak' => 'required_if:status,ditolak|max:255',
        'notifikasi' => 'required|array',
        'notifikasi.*' => 'in:email,wa,both'
    ]);

    $izin = Izin::with('pegawai')->findOrFail($id);
    $izin->status = $request->status;
    $izin->alasan_ditolak = $request->status === 'ditolak' ? $request->alasan_ditolak : null;

    if ($izin->save()) {
        $notificationMethod = $request->notifikasi[$id] ?? 'email';
        $pegawai = $izin->pegawai;

       
        $statusText = $request->status === 'disetujui' ? 'DISETUJUI' : 'DITOLAK';
        $messageContent = "Halo {name},\n\nPengajuan izin Anda pada tanggal {$izin->tanggal_izin->format('d-m-Y')} " .
            "jam {$izin->jam_mulai} - {$izin->jam_selesai} dengan alasan  *{$izin->alasan}* telah {$statusText}.\n";

        if ($request->status === 'ditolak') {
            $messageContent .= "Alasan Penolakan: *{$request->alasan_ditolak}*\n";
        }
        $messageContent .= "\nTerima kasih.";

     
        $target = $pegawai->no_wa . '|' . $pegawai->name . '|Employee';

      
        switch ($notificationMethod) {
            case 'email':
                Mail::to($pegawai->email)->send(new StatusIzinMail($izin));
                break;

            case 'wa':
                if (!empty($pegawai->no_wa)) {
                    $this->sendWhatsAppMessage($target, $messageContent, [
                        'delay' => '2', 
                        'typing' => true 
                    ]);
                }
                break;

            case 'both':
                Mail::to($pegawai->email)->send(new StatusIzinMail($izin));
                if (!empty($pegawai->no_wa)) {
                    $this->sendWhatsAppMessage($target, $messageContent, [
                        'url' => asset('images/logo.png'), 
                        'filename' => 'company_logo.png'
                    ]);
                }
                break;
        }

        return redirect()->route('atasan.pengajuan')->with(
            'success',
            'Pengajuan izin sudah dikonfirmasi dan notifikasi terkirim via ' .
                $this->getNotificationMethodText($notificationMethod)
        );
    }

    return back()->with('error', 'Gagal memproses pengajuan izin');
}

    private function getNotificationMethodText($method)
    {
        switch ($method) {
            case 'email':
                return 'Email';
            case 'wa':
                return 'WhatsApp';
            case 'both':
                return 'Email dan WhatsApp';
            default:
                return '';
        }
    }

    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (preg_match('/^0/', $phone)) {
            return preg_replace('/^0/', '62', $phone);
        }
        if (!preg_match('/^62/', $phone)) {
            return '62' . $phone;
        }
        return $phone;
    }

     private function sendWhatsAppMessage($phone, $message, $options = [])
{
    $fonnteService = new FonnteService();
    
    $params = [
        'target' => $phone,
        'message' => $message,
        'countryCode' => '62',
    ];

    $params = array_merge($params, $options);

    try {
        $response = $fonnteService->sendMessage($params);
        
        Log::info('WhatsApp API Response:', [
            'phone' => $phone,
            'message' => $message,
            'response' => $response
        ]);

        return $response;
    } catch (\Exception $e) {
        Log::error('WhatsApp API Error:', [
            'phone' => $phone,
            'message' => $message,
            'error' => $e->getMessage()
        ]);
        
        return [
            'status' => false,
            'message' => $e->getMessage()
        ];
    }
}

 public function historiIzin(Request $request)
{
    $query = Izin::with('pegawai')
        ->whereIn('status', ['disetujui', 'ditolak'])
        ->orderBy('tanggal_izin', 'desc');

    
    if ($request->filled('name')) {
        $query->whereHas('pegawai', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        });
    }

    
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_izin', $request->tahun);
    } else {
    
        $query->whereYear('tanggal_izin', now()->year);
    }

    
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_izin', $request->bulan);

     
        if ($request->filled('minggu')) {
            $startOfMonth = Carbon::create($request->tahun ?? now()->year, $request->bulan, 1);
            $startOfWeek = $startOfMonth->copy()->addWeeks($request->minggu - 1)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
            $query->whereBetween('tanggal_izin', [$startOfWeek, $endOfWeek]);
        }
    }

    $histori = $query->paginate(10)->withQueryString();

    return view('atasan.histori', compact('histori'));
}
    public function loadPegawai(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $pegawai = User::select('id', 'name as text')
                ->where('jabatan', 'pegawai')
                ->where('name', 'like', '%' . $search . '%')
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

        if ($request->filled('name')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $bulanInput = $request->bulan ?? null;
        $tahun = $request->tahun ?? now()->year;
        $bulan = is_numeric($bulanInput) ? $bulanInput : ($namaBulan[$bulanInput] ?? null);

        if ($bulan) {
            $query->whereMonth('tanggal_izin', $bulan)
                ->whereYear('tanggal_izin', $tahun);
        }

        if ($request->filled('minggu')) {
            $bulanUntukMinggu = $bulan ?? now()->month;
            $startOfMonth = Carbon::createFromDate($tahun, $bulanUntukMinggu, 1);
            $startOfWeek = $startOfMonth->copy()->addWeeks($request->minggu - 1)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
            $query->whereBetween('tanggal_izin', [$startOfWeek, $endOfWeek]);
        }

        $histori = $query->where('status', 'disetujui')
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        $bulanTeks = $bulan ? array_search($bulan, $namaBulan) : 'Semua Bulan';
        $mingguTeks = $request->filled('minggu') ? 'Minggu ke-' . $request->minggu : 'Semua Minggu';
        $tahunTeks = $tahun ?: 'Semua Tahun';
        $namaTeks = $request->filled('name') ? $request->name : 'Semua Pegawai';

        $pdf = Pdf::loadView('pdf.histori-izin', [
            'histori' => $histori,
            'bulan' => $bulanTeks,
            'minggu' => $mingguTeks,
            'tahun' => $tahunTeks,
            'name' => $namaTeks,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('histori-izin.pdf');
    }

    public function historiPegawai()
    {
        $pegawai = Auth::user();

        $histori = Izin::where('pegawai_id', $pegawai->id)
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('pegawai.histori-izin', [
            'histori' => $histori,
            'pegawai' => $pegawai
        ]);
    }
}
