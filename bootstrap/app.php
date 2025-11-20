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
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'theme' => \App\Http\Middleware\ThemeMiddleware::class,
            'nocache' => \App\Http\Middleware\NoCacheMiddleware::class,
            'validate.session' => \App\Http\Middleware\ValidateSessionMiddleware::class,
            'strict.auth' => \App\Http\Middleware\StrictAuthMiddleware::class,
            'force.auth' => \App\Http\Middleware\ForceAuthMiddleware::class,
            'cleanup.sessions' => \App\Http\Middleware\CleanupSessionsMiddleware::class,
        ]);

        // Appliquer le middleware no-cache à toutes les routes web
        $middleware->web(append: [
            \App\Http\Middleware\NoCacheMiddleware::class,
            \App\Http\Middleware\CleanupSessionsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
