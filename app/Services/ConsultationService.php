<?php
namespace App\Services;

use App\Models\Consultation;
use App\Models\DossierMedical;
use App\Models\Patient;
use App\Models\Personnel;
use App\Models\SalleAttente;
use App\Models\Service;
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
public function updateConsultation($id, array $data)
{
    return DB::transaction(function() use ($id, $data) {
        // Récupérer la consultation existante
        $consultation = Consultation::findOrFail($id);
        
        // Récupérer le patient
        $patient = Patient::findOrFail($consultation['patient_id']);
        $medecin = Personnel::findOrFail($consultation['medecin_id']);
        $service = Service::findOrFail($consultation['service_id']);
        // dd($service);

        // Mettre à jour les informations du dossier médical si elles sont présentes
        if (isset($data['dossierMedical'])) {
            $dossierMedical = DossierMedical::where('patient_id', $patient->id)->first();
            if ($dossierMedical) {
                $dossierMedical->update([
                    'numero_dossier' => $data['dossierMedical']['numero_dossier'] ?? $dossierMedical->numero_dossier,
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? $dossierMedical->antecedents,
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? $dossierMedical->diagnostics,
                    'traitements' => $data['dossierMedical']['traitements'] ?? $dossierMedical->traitements,
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? $dossierMedical->prescriptions,
                ]);
            } else {
                // Si le dossier médical n'existe pas, on le crée
                $dossierMedical = DossierMedical::create([
                    'numero_dossier' => $data['dossierMedical']['numero_dossier'] ?? null,
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? [],
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? [],
                    'traitements' => $data['dossierMedical']['traitements'] ?? [],
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? [],
                    'patient_id' => $patient->id,
                ]);
            }
        }
        // Mettre à jour les informations de la consultation
        $consultation->update([
            'libelle' => $data['libelle'] ?? $consultation->libelle,
            'medecin_id' =>   $data['medecin_id'] ?? $medecin->id,
            'service_id' =>  $data['service_id'] ?? $service->id,
            'patient_id' =>  $data['patient_id'] ?? $patient->id,
            'notes' => $data['notes'] ?? $consultation->notes,
            'date_consultation' => $data['date_consultation'] ?? $consultation->date_consultation,
        ]);

        return $consultation->load('medecin', 'patient.dossierMedical','service');
    });
}


public function createConsultation($salleAttenteId, array $data)
{
      return DB::transaction(function() use ($salleAttenteId ,$data) {
        $salleAttente = SalleAttente::findOrFail($salleAttenteId);
        $service = Service::findOrFail($salleAttente->service_id);
        $patient = Patient::with('dossierMedical')->find($salleAttente->patient_id);
       
        // Création de la consultation
        $consultation = Consultation::create([
            'patient_id' => $patient->id,
            'service_id' => $service->id,
            'medecin_id' => $data['medecin_id'],
            'libelle'=> $data['libelle'],
            'date_consultation' => now(),
            'notes' => $data['notes'] ?? null,
        ]);

        // Mise à jour ou création du dossier médical du patient
        // $dossierMedical = DossierMedical::where('patient_id', $patient->id,)->first();
        $dossierMedical=$patient['dossierMedical'];
        
        if ($dossierMedical) {
            // Si le dossier médical existe, on le met à jour
            $dossierMedical->update([
                'antecedents' => array_merge(
                    $dossierMedical->antecedents ?? [],
                    $data['dossierMedical']['antecedents'] ?? []
                ),
                'diagnostics' => array_merge(
                    $dossierMedical->diagnostics ?? [],
                    $data['dossierMedical']['diagnostics'] ?? []
                ),
                'traitements' => array_merge(
                    $dossierMedical->traitements ?? [],
                    $data['dossierMedical']['traitements'] ?? []
                ),
                'prescriptions' => array_merge(
                    $dossierMedical->prescriptions ?? [],
                    $data['dossierMedical']['prescriptions'] ?? []
                ),
            ]);
        } else {
            // Si le dossier médical n'existe pas, on le crée
            $dossierMedical = DossierMedical::create([
                'patient_id' => $data['patient_id'],
                'numero_dossier' => $data['dossierMedical']['numero_dossier'],
                'antecedents' => $data['dossierMedical']['antecedents'] ?? null,
                'diagnostics' => $data['dossierMedical']['diagnostics'] ?? null,
                'traitements' => $data['dossierMedical']['traitements'] ?? null,
                'prescriptions' => $data['dossierMedical']['prescriptions'] ?? null,
            ]);
        }

        return $consultation->load('patient', 'medecin','service');
    });
}


}