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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'    => \App\Http\Middleware\AdminMiddleware::class,
            'leader'   => \App\Http\Middleware\LeaderMiddleware::class,
            'referral' => \App\Http\Middleware\CheckReferral::class,
        ]);
        // CheckReferral hanya dijalankan di route /login via alias 'referral'.
        // JANGAN append ke global web middleware — menyebabkan conflict session/CSRF
        // yang mengakibatkan "Page Expired" saat logout dan form POST lainnya.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
