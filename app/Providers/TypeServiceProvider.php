<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TypeServiceProvider extends ServiceProvider
{
  
    const ADMIN = "medecin";
    const MEDECIN = "medecin";
    const INFIRMIER = "infirmier";
    const AIDE_SOIGNANT = "aide soignant";
    const PARAMEDICAUX = "paramedicaux";
    const BRANCARDIER = "brancardier";
    const AMBULANCIER = "ambulancier";
    const TECHNICIEN_DE_SURFACE = "technicien de surface";
    const SECRETAIRE = "secretaire";
    const COMPTABLE = "comptable";
    const CAISSIER = "caissier";
    const AGENT_SECURITE = "agent securite";
    const ACCUEIL = "accueil";
    const DG = "dg";
    const DRG = "drg";

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
