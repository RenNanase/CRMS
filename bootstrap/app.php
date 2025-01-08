<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'user.access' => \App\Http\Middleware\UserAccess::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'is_dean' => \App\Http\Middleware\IsDean::class, // Add this line
            'check.major.registration' => \App\Http\Middleware\CheckMajorRegistrationPeriod::class, //major
            'check.registration' => \App\Http\Middleware\CheckRegistrationPeriod::class, //minor
        ]);

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
