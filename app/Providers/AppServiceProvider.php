<?php

namespace App\Providers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enable Debugbar only for whitelisted IPs.
        $allowedIPs = array_filter(array_map('trim', explode(',', config('app.debug_allowed_ips'))));

        if (! empty($allowedIPs)) {
            in_array(Request::ip(), $allowedIPs) ? Debugbar::enable() : Debugbar::disable();
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Keep indexed varchar columns under MySQL’s 1 000-byte key limit.
        Schema::defaultStringLength(191);

        // Automatically seed when Laravel’s Parallel Testing spins up a DB.
        ParallelTesting::setUpTestDatabase(function (string $database, int $token) {
            Artisan::call('db:seed');
        });
    }
}
