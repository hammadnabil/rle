<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IzinController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:pegawai')->get('/pegawai/dashboard', function () {
    return view('pegawai.dashboard');})->name('pegawai.dashboard');
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

Route::middleware('auth:atasan')->get('/atasan/dashboard', function () {
    return view('atasan.dashboard');
})->name('atasan.dashboard');
Route::get('/atasan/pengajuan', [IzinController::class, 'pengajuanIzin'])->name('atasan.pengajuan');
    Route::post('/atasan/pengajuan/{id}', [IzinController::class, 'setujuiTolak'])->name('atasan.setujuiTolak');




