<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Instansi\DashboardController as InstansiDashboard;
use App\Http\Controllers\Instansi\Auth\LoginController as InstansiLoginController;
use App\Http\Controllers\Instansi\ProfileController as InstansiProfileController;
use App\Http\Controllers\Instansi\LaporanController as InstansiLaporanController;
use App\Http\Controllers\PublicLaporanController;
use App\Http\Controllers\WelcomeController;


Route::get('/', [WelcomeController::class, 'index'])->name('home');


Route::get('/laporan/buat/{tipe?}', [LaporanController::class, 'create'])
     ->middleware('auth') // Hanya pengguna yang login bisa akses
     ->name('laporan.create');
     Route::post('/laporan/simpan', [LaporanController::class, 'store'])->name('laporan.store');
     Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
     Route::get('/profil/ubah', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    
    Route::post('/laporan/{id}/tindak-lanjut', [LaporanController::class, 'storeTindakLanjut'])->name('laporan.tindak-lanjut.store');
    Route::post('/laporan/{id}/komentar', [LaporanController::class, 'storeKomentar'])->name('laporan.komentar.store');
    Route::post('/laporan/{id}/dukung', [LaporanController::class, 'dukung'])->name('laporan.dukung.store');

Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    
    // Route Proses Verifikasi (Tolak/Setujui)
    Route::patch('/laporan/{id}/verifikasi', [AdminLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    Route::get('/laporan/{id}/progres', [AdminLaporanController::class, 'showProgres'])->name('laporan.progres');
    Route::post('/laporan/{id}/selesai', [AdminLaporanController::class, 'selesai'])->name('laporan.selesai');
    Route::post('/laporan/{id}/dukung', [AdminLaporanController::class, 'dukung'])->name('laporan.dukung');
    Route::post('/laporan/{id}/komentar', [AdminLaporanController::class, 'storeKomentar'])->name('laporan.komentar');
});

Route::prefix('instansi')->name('instansi.')->group(function () {
    
    // Rute Tamu (Belum Login)
    Route::middleware('guest:instansi')->group(function () {
        Route::get('/login', [InstansiLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [InstansiLoginController::class, 'login']);
    });

    // Rute Dashboard (Sudah Login)
    Route::middleware('auth:instansi')->group(function () {
        Route::get('/dashboard', [InstansiDashboard::class, 'index'])->name('dashboard');
        Route::get('/laporan/{id}', [InstansiLaporanController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{id}/tindak-lanjut', [InstansiLaporanController::class, 'storeTindakLanjut'])->name('laporan.tindak-lanjut');
    Route::post('/laporan/{id}/komentar', [InstansiLaporanController::class, 'storeKomentar'])->name('laporan.komentar');
    Route::post('/laporan/{id}/selesai', [InstansiLaporanController::class, 'selesai'])->name('laporan.selesai');
    Route::post('/laporan/{id}/dukung', [InstansiLaporanController::class, 'dukung'])->name('laporan.dukung');
        Route::get('/profil', [InstansiProfileController::class, 'index'])->name('profil.index');
        Route::post('/logout', [InstansiLoginController::class, 'logout'])->name('logout');
    });
});
Route::get('/jelajah', [PublicLaporanController::class, 'index'])->name('laporan.public');