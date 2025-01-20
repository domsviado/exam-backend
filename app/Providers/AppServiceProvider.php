<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\MaintenanceMode;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Filesystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
