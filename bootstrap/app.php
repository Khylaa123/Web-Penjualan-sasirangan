<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // INI YANG KITA TAMBAHKAN: Mendaftarkan nama panggilan 'role' untuk satpam kita
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRole::class,
        ]);
        
        // TAMBAHKAN BLOK INI: Pengecualian untuk Midtrans
        $middleware->validateCsrfTokens(except: [
            'midtrans-callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();