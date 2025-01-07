<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function (): void {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api/v1/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/guest/web.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->name('app.admin.')
                ->group(base_path('routes/app/clinic_admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
