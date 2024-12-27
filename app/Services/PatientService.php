<?php
namespace App\Services;

use App\Models\DossierMedical;
use App\Models\Patient;
use App\Models\SalleAttente;
use Illuminate\Support\Facades\DB;

class PatientService{
    private function generateMatricule()
    {
        $prefix = "PAT_";
        $timestamp = now()->format('YmdHis');
        
        return $prefix . $timestamp ;
    }
    public function createPatient(array $data)
    {
        return DB::transaction(function() use ($data) {

            $matricule = $this->generateMatricule();
            $data['patient']['matricule'] = $matricule;
           
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

    public function storeWaitingRoom(array $data){
        
        return DB::transaction(function() use ($data) {  
            // Vérifier si le patient existe déjà
           if ($data['matricule']) {
            $patient = Patient::where('matricule', $data['matricule'])
            ->first();
           }

            // Si le patient n'existe pas, on le crée
            if (!$patient) {
                $matricule = $this->generateMatricule();

                $patient = Patient::create([
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'adresse' => $data['adresse'] ?? null,
                    'telephone' => $data['telephone'] ?? null,
                    'date_naissance' => $data['date_naissance'] ?? null,
                    'email' => $data['email'] ?? null,
                    'sexe' => $data['sexe'] ?? null,
                    'groupe_sanguin' => $data['groupe_sanguin'] ?? null,
                    'matricule' => $matricule
                ]);
            }

            // Vérifier si le patient est déjà dans la salle d'attente pour ce service
            $salleAttente = SalleAttente::where('patient_id', $patient->id)
                                        ->where('service_id', $data['service_id'])
                                        ->where('etat', 'en attente')
                                        ->first();                                        

            // Si le patient n'est pas déjà dans la salle d'attente, l'ajouter
            if (!$salleAttente) {
                $salleAttente = SalleAttente::create([
                    'patient_id' => $patient->id,
                    'service_id' => $data['service_id'],
                    'date_entree' => now(),
                    'etat' => 'en attente',
                ]);
            }

            return ['patient' => $patient, 'salle_attente' => $salleAttente];
        });
    
    }

    public function updatePatient(Patient $patient, array $data)
    {
        return DB::transaction(function() use ($patient, $data) {
            
            // Mise à jour des informations du patient
            $patient->update($data['patient']);
    
            // Si les données du dossier médical sont présentes, on gère la mise à jour ou la création du dossier
            if (isset($data['dossierMedical'])) {
                $patient->dossierMedical->update($data['dossierMedical']);
             } 
            
            return $patient->load('dossierMedical');
        });
    }

    public function ajouterDossierPatient($patient, $dossier){
        return DB::transaction(function() use ($patient, $dossier){

            // Si les données du dossier médical sont présentes, on gère la mise à jour ou la création du dossier
            if (isset($data['dossierMedical'])) {
                $patient->dossierMedical->update($dossier['dossierMedical']);
             } 
             else {
                    // Création d'un nouveau dossier médical si le patient n'en a pas encore
                    DossierMedical::create([
                        'numero_dossier' => $dossier['dossierMedical']['numero_dossier'],
                        'antecedents' => $dossier['dossierMedical']['antecedents'],
                        'diagnostics' => $dossier['dossierMedical']['diagnostics'],
                        'traitements' => $dossier['dossierMedical']['traitements'],
                        'prescriptions' => $dossier['dossierMedical']['prescriptions'],
                        'patient_id' => $patient->id,
                    ]);
            }
    
            return $patient->load('dossierMedical');
        });
    }
    

    public function getPatientWithMedicalRecord($id)
    {
        return Patient::with('dossierMedical')->findOrFail($id);
    }

    public function ajouterPatientSalleAttente(array $data)
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

    public function updateWaitingRoom($id, array $data)
    {
        return DB::transaction(function() use ($id, $data) {
            // Récupérer le patient par son ID
            $patient = Patient::findOrFail($id);
    
            // Mettre à jour les informations du patient
            $patient->update([
                'nom' => $data['nom'] ?? $patient->nom,
                'prenom' => $data['prenom'] ?? $patient->prenom,
                'adresse' => $data['adresse'] ?? $patient->adresse,
                'telephone' => $data['telephone'] ?? $patient->telephone,
                'date_naissance' => $data['date_naissance'] ?? $patient->date_naissance,
                'email' => $data['email'] ?? $patient->email,
                'sexe' => $data['sexe'] ?? $patient->sexe,
                'groupe_sanguin' => $data['groupe_sanguin'] ?? $patient->groupe_sanguin,
                'matricule' => $data['matricule'] ?? $patient->matricule,
            ]);
    
            // Vérifier si le patient est dans la salle d'attente pour ce service
            $salleAttente = SalleAttente::where('patient_id', $patient->id)
                                        ->where('service_id', $data['service_id'])
                                        ->first();
    
            if ($salleAttente) {
                // Mettre à jour l'état de la salle d'attente si nécessaire
                $salleAttente->update([
                    'etat' => $data['etat'] ?? $salleAttente->etat,
                    'date_entree' => $data['date_entree'] ?? $salleAttente->date_entree,
                ]);
            } else {
                // Si le patient n'est pas dans la salle d'attente, on le rajoute
                $salleAttente = SalleAttente::create([
                    'patient_id' => $patient->id,
                    'service_id' => $data['service_id'],
                    'date_entree' => $data['date_entree'] ?? now(),
                    'etat' => $data['etat'] ?? 'en attente',
                ]);
            }
    
            return ['patient' => $patient, 'salle_attente' => $salleAttente];
        });
    }
    
}