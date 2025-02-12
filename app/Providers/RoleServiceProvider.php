<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{

    const SUPER_ADMIN = "SUPER ADMIN";
    const ADMIN = "ADMIN";
    const MEDECIN = "MEDECIN";
    const INFIRMIER = "INFIRMIER";
    const ASSISTANT = "ASSISTANT";
    const SECRETAIRE = "SECRETAIRE";
    const CAISSIER = "CAISSIER";
    const SECURITE = "SECURITE";
    const AMBULANCIER = "AMBULANCIER";
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
