<?php
namespace App\Services;

use App\Models\Consultation;
use App\Models\DossierMedical;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class ConsultationService{
    public function createOrUpdateConsultation(array $data)
{
    
    return DB::transaction(function() use ($data) {
        // Vérification de l'existence du patient
        $patient = Patient::find($data['patient']['id'] ?? null);

        if (!$patient) {
            // Création du patient si inexistant
            $patient = Patient::create($data['patient']);

            // Création du dossier médical si présent
            if (isset($data['dossierMedical'])) {
                DossierMedical::create([
                    'numero_dossier' => $data['dossierMedical']['numero_dossier'],
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? [],
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? [],
                    'traitements' => $data['dossierMedical']['traitements'] ?? [],
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? [],
                    'patient_id' => $patient->id,
                ]);
            }
        } else {
            // Mise à jour du dossier médical si le patient existe
            $dossierMedical = DossierMedical::where('patient_id', $patient->id)->first();

            if ($dossierMedical) {
                $dossierMedical->update([
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? $dossierMedical->antecedents,
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? $dossierMedical->diagnostics,
                    'traitements' => $data['dossierMedical']['traitements'] ?? $dossierMedical->traitements,
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? $dossierMedical->prescriptions,
                ]);
            }
        }

        // Création de la consultation
        $consultation = Consultation::create([
            'libelle' => $data['consultation']['libelle'],
            'medecin_id' => $data['consultation']['medecin_id'],
            'patient_id' => $patient->id,
            'dadate_consultationte' => $data['consultation']['date_consultation'],
            'notes' => $data['consultation']['notes'],
        ]);

        return $consultation->load('medecin', 'patient.dossierMedical');;
    });
}

}