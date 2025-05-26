<?php
return [
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
    ],
    'middleware' => [
        'base' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ],
        'auth' => [
            \Filament\Http\Middleware\Authenticate::class,
        ],
    ],
];