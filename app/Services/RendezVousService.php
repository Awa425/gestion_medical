<?php
namespace App\Services;

use App\Models\RendezVous;
use Carbon\Carbon;

class RendezVousService
{
    public function creerRendezVous($data)
    {
        // Vérifier la disponibilité du médecin à l'heure donnée
        $this->verifierDisponibilite($data['medecin_id'], $data['date_heure']);

        // Créer le rendez-vous
        return RendezVous::create([
            'patient_id' => $data['patient_id'],
            'medecin_id' => $data['medecin_id'],
            'service_id' => $data['service_id'],
            'date_heure' => $data['date_heure'],
            'motif' => $data['motif'],
            'statut' => 'programmé',
        ]);
    }

    public function verifierDisponibilite($medecin_id, $date_heure)
    {
        // Vérifier s'il n'y a pas déjà un rendez-vous à cette date pour le médecin
        $existe = RendezVous::where('medecin_id', $medecin_id)
                    ->where('date_heure', $date_heure)
                    ->exists();

        if ($existe) {
            throw new \Exception('Le médecin n\'est pas disponible à cette heure.');
        }
    }

    public function annulerRendezVous($rendezVousId)
    {
        $rendezVous = RendezVous::findOrFail($rendezVousId);
        $rendezVous->update(['statut' => 'annulé']);
    }
}
