<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],


    'guards' => [
        'colaborador' => [
            'driver' => 'session',
            'provider' => 'colaboradores',
        ],
        'supervisor' => [
            'driver' => 'session',
            'provider' => 'supervisores',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'colaboradores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'supervisores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Supervisor::class,
        ],

    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
