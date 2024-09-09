<?php
namespace App\Services;

use App\Models\Patient;

class ServiceBase{
    
    private function generateMatriculePatient($patient)
    {
        $date = now()->format('Ymd'); // Date d'enregistrement au format AAAAMMJJ
        $nom = strtoupper(substr($patient['nom'], 0, 3)); // Les 3 premières lettres du nom en majuscules
        $nombrePatients = Patient::count() + 1; // Le nombre total de patients + 1 pour l'actuel

        // Format final : NOMAAAAMMJJXXX (XXX est un numéro incrémental basé sur le nombre de patients)
        $matricule = sprintf('%s%s%03d', $nom, $date, $nombrePatients);

        return $matricule;
    }
}