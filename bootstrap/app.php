<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\RemoveWwwMiddleware;
use App\Http\Middleware\SecurityDepositMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('agent')
                ->name('agent.')
                ->group(base_path('routes/agent.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(RemoveWwwMiddleware::class);
        $middleware->validateCsrfTokens(except: [
            '/webhook/github',
        ]);
        $middleware->alias([
            'user.active' => CheckUserStatus::class,
            'topup.verified' => SecurityDepositMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {})->create();
