<?php
namespace App\Services;

use App\Mail\RendezVousCreeMail;
use App\Models\Disponibilite;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RendezVousService
{
    public function creerRendezVous($data)
    {
        // Vérifier la disponibilité du médecin à l'heure donnée
        $this->verifierDisponibilite($data['medecin_id'], $data['date_heure']);

        // Créer le rendez-vous
        $rendezVous= RendezVous::create([
            'patient_id' => $data['patient_id'],
            'medecin_id' => $data['medecin_id'],
            'service_id' => $data['service_id'],
            'date_heure' => $data['date_heure'],
            'motif' => $data['motif'],
            'statut' => 'programmé',
        ]);
        // $spliteDate=$this->splitDateTime($data['date_heure']);

        // $disponibilité = Disponibilite::where('medecin_id',$data['medecin_id'])->where('date',$spliteDate['date'])->where('heure',$spliteDate['heure']);
        // $disponibilité['est_disponible']=false;
        // $disponibilité->update(['est_disponible'=>false]);

        $patient = $rendezVous->patient;
        // Mail::to($patient->email)->send(new RendezVousCreeMail($rendezVous));
        
        return $rendezVous;
    }

   public function splitDateTime(string $dateTime):array{
    $carbon = Carbon::parse($dateTime);
    return[
        'date'=>$carbon->format('Y-m-d'),
        'time'=>$carbon->format('H:i:s')
    ];
   }

    public function verifierDisponibilite($medecin_id, $date_heure)
    {
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
