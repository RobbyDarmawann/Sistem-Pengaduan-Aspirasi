<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <--- JANGAN LUPA INI

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Mengatur arah redirect jika user belum login
        $middleware->redirectGuestsTo(function (Request $request) {
            
            // 1. Jika mencoba masuk halaman Admin -> Ke Login Admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            
            // 2. Jika mencoba masuk halaman Instansi -> Ke Login Instansi
            if ($request->is('instansi') || $request->is('instansi/*')) {
                return route('instansi.login');
            }

            // 3. Jika Pengguna biasa -> Ke Halaman Utama (Modal Login ada di sana)
            return url('/');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();