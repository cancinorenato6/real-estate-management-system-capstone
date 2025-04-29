<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\MiddlewareNameResolver; // Just in case
use App\Http\Middleware\GuestWithAlert;
use App\Http\Middleware\GuestAlertClientMW;
use App\Http\Middleware\GuestAlertAdminMW;

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
        Paginator::useBootstrapFive();
    }
}
