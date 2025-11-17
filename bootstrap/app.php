<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Hapus 'use' yang tidak perlu jika ada (seperti AuthenticationException)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika request adalah untuk 'admin' atau 'admin/*'
            if ($request->is('admin') || $request->is('admin/*')) {
                // Arahkan ke rute login admin
                return route('admin.login');
            }
            // Jika tidak, arahkan ke halaman utama (untuk pengguna)
            return url('/');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();