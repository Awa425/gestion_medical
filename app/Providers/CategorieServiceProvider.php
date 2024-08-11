<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CategorieServiceProvider extends ServiceProvider
{

    const PERSONNEL_ADMINISTRATIF = "personnel administratif";
    const PERSONNEL_SANTE = "personnel sante";
    const PERSONNEL_SOUTIENT = "personnel soutient";
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
