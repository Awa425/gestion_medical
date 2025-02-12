<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CategorieServiceProvider extends ServiceProvider
{

    const ADMINISTRATIF = "ADMINISTRATIF";
    const SANTE = "SANTE";
    const SOUTIENT = "SOUTIENT";
    const SECURITE = "SECURITE";
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
