<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Definisikan gate untuk memeriksa role admin
        Gate::define('access-filament', function ($user) {
            return $user->role === 'admin';
        });

        // Terapkan gate ke Filament
        Filament::serving(function () {
            if (! Gate::allows('access-filament')) {
                abort(403, 'ngapain lu ke halaman admin');
            }
        });
    }
}
