<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\CheckIfRemember;
use App\Http\Middleware\CustomAuthMiddleware;
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
        $middleware->alias([
            'custom.auth' => CustomAuthMiddleware::class,
            'admin.auth' => AdminAuth::class,
            'custom.rememberme' => CheckIfRemember::class
            
        ])->
        validateCsrfTokens(except: [
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
