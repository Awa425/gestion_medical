<?php

namespace App\Services;

use App\Models\HoraireTravail;
use App\Models\RotationPersonnel;
use Illuminate\Support\Facades\DB;

class PersonnelPlanningService{

    public function planifierHorairePourPersonnel(array $data): RotationPersonnel
    {
        return DB::transaction(function() use ($data) {
            // Créer l'horaire
            $horaire = HoraireTravail::create([
                'date' => $data['date'],
                'heure_debut' => $data['heure_debut'],
                'heure_fin' => $data['heure_fin'],
                'type_horaire' => $data['type_horaire'],
            ]);

            // Affecter l'horaire au personnel
            return RotationPersonnel::create([
                'id_personnel' => $data['id_personnel'],
                'id_horaire' => $horaire->id_horaire,
                'date_affectation' => $data['date_affectation'],
                'commentaires' => $data['commentaires'] ?? null,
            ]);
        });
    }

}