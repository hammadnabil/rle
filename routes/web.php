    <?php

    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\IzinController;


    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::middleware(['auth', 'cek.jabatan:atasan'])->group(function () {
        Route::get('/atasan/dashboard', function () {
            return view('atasan.dashboard');
        })->name('atasan.dashboard');
        Route::get('/atasan/pengajuan', [IzinController::class, 'pengajuanIzin'])->name('atasan.pengajuan');
        Route::post('/atasan/pengajuan/{id}', [IzinController::class, 'setujuiTolak'])->name('atasan.setujuiTolak');
        Route::get('/atasan/histori', [IzinController::class, 'historiIzin'])->name('atasan.histori');
        Route::get('/cari-pegawai', [IzinController::class, 'loadPegawai'])->name('cari.pegawai');
        Route::get('/atasan/histori/export', [IzinController::class, 'exportPDF'])->name('atasan.histori.export');
        
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/pegawai/dashboard', function () {
            return view('pegawai.dashboard');
        })->name('pegawai.dashboard');
        Route::get('/pegawai/izin', [IzinController::class, 'index'])->name('izin.index'); // ← tambahkan ini
        Route::post('/pegawai/izin', [IzinController::class, 'store'])->name('izin.store');
    });






    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');