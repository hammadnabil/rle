    <?php

    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\IzinController;
    use App\Http\Controllers\PegawaiController;
    use App\Http\Controllers\AtasanController;


    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::middleware(['auth', 'cek.jabatan:Tata Usaha'])->group(function () {
        Route::get('/atasan/dashboard', function () {
            return view('atasan.dashboard');
        })->name('atasan.dashboard');
        Route::get('/atasan/pengajuan', [IzinController::class, 'pengajuanIzin'])->name('atasan.pengajuan');
        Route::post('/atasan/pengajuan/{id}', [IzinController::class, 'setujuiTolak'])->name('atasan.setujuiTolak');
        Route::get('/atasan/histori', [IzinController::class, 'historiIzin'])->name('atasan.histori');
        Route::get('/cari-pegawai', [IzinController::class, 'loadPegawai'])->name('cari.pegawai');
        Route::get('/atasan/histori/export', [IzinController::class, 'exportPDF'])->name('atasan.histori.export');
        Route::get('/atasan/user', [AtasanController::class, 'listUser'])->name('atasan.user.index');
        Route::get('/atasan/profil', [AtasanController::class, 'profil'])->name('atasan.profil');

        Route::get('/autocomplete', [AtasanController::class, 'autocomplete'])->name('atasan.autocomplete');

        Route::get('/atasan/user/{user}', [AtasanController::class, 'detailUser'])->name('atasan.user.detail');

    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/pegawai/dashboard', function () {
            return view('pegawai.dashboard');
        })->name('pegawai.dashboard');
        Route::get('/pegawai/izin', [IzinController::class, 'index'])->name('izin.index'); // ← tambahkan ini
        Route::post('/pegawai/izin', [IzinController::class, 'store'])->name('izin.store');
          Route::get('/pegawai/histori-izin', [IzinController::class, 'historiPegawai'])->name('pegawai.histori-izin');
          Route::get('/pegawai/profil', [PegawaiController::class, 'profil'])->name('pegawai.profil');
    });






Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


