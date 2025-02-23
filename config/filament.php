<?php

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\Authorize;
use Filament\Http\Middleware\RedirectIfAuthenticated;

return [

    /*
    |--------------------------------------------------------------------------
    | Panels
    |--------------------------------------------------------------------------
    |
    | This is where you define the panels of your Filament application.
    | You may define as many panels as you like.
    |
    */

    'panels' => [
        'admin' => [
            'id' => 'admin',
            'path' => 'admin',
            'login' => [
                'path' => 'login',
            ],
            'middleware' => [
                'auth:sanctum',
                config('jetstream.middleware', 'verified'),
            ],
            'auth' => [
                'guard' => 'web',
                'pages' => [
                    'login' => \Filament\Pages\Auth\Login::class,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    */

    'broadcasting' => [
        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'wsHost' => env('VITE_PUSHER_HOST'),
        //     'wsPort' => env('VITE_PUSHER_PORT'),
        //     'wssPort' => env('VITE_PUSHER_PORT'),
        //     'authEndpoint' => '/broadcasting/auth',
        //     'disableStats' => true,
        //     'encrypted' => true,
        //     'forceTLS' => true,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Assets Path
    |--------------------------------------------------------------------------
    */

    'assets_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache Path
    |--------------------------------------------------------------------------
    */

    'cache_path' => base_path('bootstrap/cache/filament'),

    /*
    |--------------------------------------------------------------------------
    | Livewire Loading Delay
    |--------------------------------------------------------------------------
    */

    'livewire_loading_delay' => 'default',

];
