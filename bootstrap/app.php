<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CorsMiddleware;




return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'admin/api/asistencias/register',
            'admin/api/asistencias/update/*',
            'admin/api/datos/update/colaborador/*',
            'admin/api/update/token/usuario/*',
            'admin/api/colaborador/login',

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();
