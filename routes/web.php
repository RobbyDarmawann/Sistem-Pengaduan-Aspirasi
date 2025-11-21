<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/laporan/buat/{tipe?}', [LaporanController::class, 'create'])
     ->middleware('auth') // Hanya pengguna yang login bisa akses
     ->name('laporan.create');

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
Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    
    // Route Proses Verifikasi (Tolak/Setujui)
    Route::patch('/laporan/{id}/verifikasi', [AdminLaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    Route::get('/laporan/{id}/progres', [AdminLaporanController::class, 'showProgres'])->name('laporan.progres');
    Route::post('/laporan/{id}/selesai', [AdminLaporanController::class, 'selesai'])->name('laporan.selesai');
    Route::post('/laporan/{id}/dukung', [AdminLaporanController::class, 'dukung'])->name('laporan.dukung');
});