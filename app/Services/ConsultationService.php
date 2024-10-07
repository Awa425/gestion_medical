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

public function createConsultation(array $data)
{
    return DB::transaction(function () use ($data) {
        // Vérifier si le patient existe
        $patient = Patient::find($data['patient_id']);

        // Créer une consultation
        $consultation = Consultation::create([
            'patient_id' => $data['patient_id'],
            'medecin_id' => $data['medecin_id'],
            'libelle' => $data['notes'],
            'date_consultation' => now(),
            'notes' => $data['notes'] ?? null,
        ]);

        // Si les données du dossier médical sont présentes, on met à jour le dossier médical ou on en crée un
        if (isset($data['dossierMedical'])) {
            // Chercher ou créer un dossier médical pour le patient
            $dossierMedical = $patient->dossierMedical()->updateOrCreate(
                ['patient_id' => $patient->id],
                [
                    'numero_dossier' => $data['dossierMedical']['numero_dossier'],
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? [],
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? [],
                    'traitements' => $data['dossierMedical']['traitements'] ?? [],
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? [],
                ]
            );
        }

        return $consultation->load('patient', 'medecin'); // Charger les relations
    });
}


}