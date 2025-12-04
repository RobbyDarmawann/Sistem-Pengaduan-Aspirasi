<?php

use Illuminate\Support\Facades\Route;

// --- CONTROLLERS PENGGUNA & PUBLIK ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PublicLaporanController;
use App\Http\Controllers\WelcomeController;

// --- CONTROLLERS ADMIN ---
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

// --- CONTROLLERS INSTANSI ---
use App\Http\Controllers\Instansi\DashboardController as InstansiDashboard;
use App\Http\Controllers\Instansi\Auth\LoginController as InstansiLoginController;
use App\Http\Controllers\Instansi\ProfileController as InstansiProfileController;
use App\Http\Controllers\Instansi\LaporanController as InstansiLaporanController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Halaman Jelajah Laporan
Route::get('/jelajah', [PublicLaporanController::class, 'index'])->name('laporan.public');

// Halaman Detail Laporan (Read Only untuk tamu)
Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

// Proses Login & Register (Guest Only)
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'store'])->name('login');


/*
|--------------------------------------------------------------------------
| RUTE PENGGUNA (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // Profil Saya
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/ubah', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

    // Buat Laporan Baru
    Route::get('/laporan/buat/{tipe?}', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan/simpan', [LaporanController::class, 'store'])->name('laporan.store');

    // Interaksi di Laporan (Komentar, Dukung, Balas Tindak Lanjut)
    Route::post('/laporan/{id}/tindak-lanjut', [LaporanController::class, 'storeTindakLanjut'])->name('laporan.tindak-lanjut.store');
    Route::post('/laporan/{id}/komentar', [LaporanController::class, 'storeKomentar'])->name('laporan.komentar.store');
    Route::post('/laporan/{id}/dukung', [LaporanController::class, 'dukung'])->name('laporan.dukung.store');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
});


/*
|--------------------------------------------------------------------------
| RUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Login Admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    // Dashboard & Fitur Admin
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');
        Route::patch('/laporan/{id}/verifikasi', [AdminLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
        
        // Progres & Interaksi Admin
        Route::get('/laporan/{id}/progres', [AdminLaporanController::class, 'showProgres'])->name('laporan.progres');
        Route::post('/laporan/{id}/selesai', [AdminLaporanController::class, 'selesai'])->name('laporan.selesai');
        Route::post('/laporan/{id}/dukung', [AdminLaporanController::class, 'dukung'])->name('laporan.dukung');
        Route::post('/laporan/{id}/komentar', [AdminLaporanController::class, 'storeKomentar'])->name('laporan.komentar');

        // Profil Admin
        Route::get('/profil', [AdminProfileController::class, 'index'])->name('profil.index');
        Route::put('/profil', [AdminProfileController::class, 'update'])->name('profil.update');
    });
});


/*
|--------------------------------------------------------------------------
| RUTE INSTANSI
|--------------------------------------------------------------------------
*/
Route::prefix('instansi')->name('instansi.')->group(function () {
    
    // Login Instansi
    Route::middleware('guest:instansi')->group(function () {
        Route::get('/login', [InstansiLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [InstansiLoginController::class, 'login']);
    });

    // Dashboard & Fitur Instansi
    Route::middleware('auth:instansi')->group(function () {
        Route::post('/logout', [InstansiLoginController::class, 'logout'])->name('logout');
        
        Route::get('/dashboard', [InstansiDashboard::class, 'index'])->name('dashboard');
        
        // Tindak Lanjut Laporan
        Route::get('/laporan/{id}', [InstansiLaporanController::class, 'show'])->name('laporan.show');
        Route::post('/laporan/{id}/tindak-lanjut', [InstansiLaporanController::class, 'storeTindakLanjut'])->name('laporan.tindak-lanjut');
        Route::post('/laporan/{id}/komentar', [InstansiLaporanController::class, 'storeKomentar'])->name('laporan.komentar');
        Route::post('/laporan/{id}/selesai', [InstansiLaporanController::class, 'selesai'])->name('laporan.selesai');
        Route::post('/laporan/{id}/dukung', [InstansiLaporanController::class, 'dukung'])->name('laporan.dukung');
        
        // Profil Instansi
        Route::get('/profil', [InstansiProfileController::class, 'index'])->name('profil.index');
    });
});