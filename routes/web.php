<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Auth\RegisterController;

Route::post('/register', [RegisterController::class, 'store'])->name('register');
