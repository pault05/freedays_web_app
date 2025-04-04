<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventBackButtonMiddleware;
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
        // Register your middleware here
        $middleware->alias(['admin' => AdminMiddleware::class, 'back' => PreventBackButtonMiddleware::class]);
//        $middleware->validateCsrfTokens(except: [
//            '/user-profile/change-password' ]);// <-- exclude this route
    })->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

