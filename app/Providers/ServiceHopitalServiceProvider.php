<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceHopitalServiceProvider extends ServiceProvider
{
    
    const CARDIOLOGIE = "SERVICE CARDIO";
    const GENERAL = "GENERAL";
    const OPHTALMOLOGIE = "SERVICE OPHTALMO";
    const PEDIATRIE = "SERVICE PEDIATRIE";
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
