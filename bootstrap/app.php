<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Pengecualian verifikasi CSRF Token untuk Webhook Midtrans
        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook',
        ]);

        // Pendaftaran Alias Middleware Custom
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'ensure.profile.completed' => \App\Http\Middleware\EnsureProfileCompleted::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
