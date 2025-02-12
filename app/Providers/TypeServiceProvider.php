<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TypeServiceProvider extends ServiceProvider
{

    const PERSONNEL_ADMINISTRATIF = "PERSONNEL_ADMINISTRATIF";
    const PERSONNEL_SANTE = "PERSONNEL_SANTE";
    const PERSONNEL_SECURITE = "PERSONNEL_SECURITE";
    const PERSONNEL_SOUTIENT = "PERSONNEL_SOUTIENT";
   
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
