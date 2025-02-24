<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\TrustHosts::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * These middleware groups may be applied to routes.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
        ],
        'filament' => [
            \Filament\Http\Middleware\Authenticate::class,
            \Filament\Http\Middleware\DisableBladeIconComponents::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware can be assigned to routes individually.
     *
     * @var array
     */
    
     protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\GuestMiddleware::class,
        'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
        'checkrole' => \App\Http\Middleware\CheckRole::class,
    ];
    

    /**
     * The application's console middleware stack.
     *
     * These middleware are run during Artisan commands.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Http\Middleware\EncryptCookies::class,
        \App\Http\Middleware\CheckAdmin::class,  // Tambahkan middleware admin jika ingin di prioritaskan
    ];
    
    
}
