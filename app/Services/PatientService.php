<?php
namespace App\Services;

use App\Models\DossierMedical;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientService{
    public function createPatient(array $data)
    {
        return DB::transaction(function() use ($data) {
           
            // Création du patient
            $patient = Patient::create($data['patient']);
            
            // Si les données du dossier médical sont présentes, on crée le dossier
            if (isset($data['dossierMedical'])) {
                $dossierMedical = DossierMedical::create([
                    'numero_dossier' =>  $data['dossierMedical']['numero_dossier'],
                    'antecedents' =>  $data['dossierMedical']['antecedents'],
                    'diagnostics' =>  $data['dossierMedical']['diagnostics'],
                    'traitements' =>  $data['dossierMedical']['traitements'],
                    'prescriptions' =>  $data['dossierMedical']['prescriptions'],
                    'patient_id' => $patient->id, // Liaison avec le patient
                ]);
            }

            return $patient->load('dossierMedical');
        });
    }

    public function updatePatient(Patient $patient, array $data)
    {
        return DB::transaction(function() use ($patient, $data) {
    
            // Mise à jour des informations du patient
            $patient->update($data['patient']);
    
            // Si les données du dossier médical sont présentes, on gère la mise à jour ou la création du dossier
            if (isset($data['dossierMedical'])) {
                if ($patient->dossierMedical) {
                    // Mise à jour du dossier médical existant
                    $patient->dossierMedical->update($data['dossierMedical']);
                } else {
                    // Création d'un nouveau dossier médical si le patient n'en a pas encore
                    DossierMedical::create([
                        'numero_dossier' => $data['dossierMedical']['numero_dossier'],
                        'antecedents' => $data['dossierMedical']['antecedents'],
                        'diagnostics' => $data['dossierMedical']['diagnostics'],
                        'traitements' => $data['dossierMedical']['traitements'],
                        'prescriptions' => $data['dossierMedical']['prescriptions'],
                        'patient_id' => $patient->id,
                    ]);
                }
            }
    
            return $patient->load('dossierMedical');
        });
    }
    

    public function getPatientWithMedicalRecord($id)
    {
        return Patient::with('dossierMedical')->findOrFail($id);
    }
}