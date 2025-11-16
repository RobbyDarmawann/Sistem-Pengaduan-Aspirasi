<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;

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