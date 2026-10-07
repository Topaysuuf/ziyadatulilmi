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
        // Bebaskan proteksi CSRF untuk route simpan agar tidak pernah 419 Page Expired
        $middleware->validateCsrfTokens(except: [
            'admin/*',
            'login',
            'ppdb',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();