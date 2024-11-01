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
private function generateNumeroDossier($id)
{

    $prefix = "PATIENT_";
    $timestamp = now()->format('YmdHis');
    
    return $prefix . $timestamp . $id;
}
public function createOrUpdateConsultation(array $data)
{

return DB::transaction(function() use ($data) {
    $patient = Patient::find($data['patient']['id'] ?? null);

    if (!$patient) {
        $patient = Patient::create($data['patient']);

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
        $consultation = Consultation::findOrFail($id);
        $patient = Patient::findOrFail($consultation['patient_id']);
        $medecin = Personnel::findOrFail($consultation['medecin_id']);
        $service = Service::findOrFail($consultation['service_id']);

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
                $dossierMedical = DossierMedical::create([
                    'numero_dossier' => $this->generateNumeroDossier( $patient->id),
                    'antecedents' => $data['dossierMedical']['antecedents'] ?? [],
                    'diagnostics' => $data['dossierMedical']['diagnostics'] ?? [],
                    'traitements' => $data['dossierMedical']['traitements'] ?? [],
                    'prescriptions' => $data['dossierMedical']['prescriptions'] ?? [],
                    'patient_id' => $patient->id,
                ]);
            }
        }
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


public function createConsultation(array $data)
{
      return DB::transaction(function() use ($data) {
        $consultation = Consultation::create([
            'patient_id' => $data['patient_id'],
            'medecin_id' => $data['medecin_id'],
            'service_id' => $data['service_id'],
            'libelle'=> $data['libelle'],
            'date_consultation' => now(),
            'notes' => $data['notes'] ?? null,
        ]);


        $dossierMedical = DossierMedical::where('patient_id', $data['patient_id'])->first();
        
        if ($dossierMedical) {
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
            $num_dossier = $this->generateNumeroDossier($data['patient_id']);
            $dossierMedical = DossierMedical::create([
                'patient_id' => $data['patient_id'],
                'numero_dossier' => $num_dossier,
                'antecedents' => $data['dossierMedical']['antecedents'] ?? null,
                'diagnostics' => $data['dossierMedical']['diagnostics'] ?? null,
                'traitements' => $data['dossierMedical']['traitements'] ?? null,
                'prescriptions' => $data['dossierMedical']['prescriptions'] ?? null,
            ]);
        }

        $salle_attente = SalleAttente::where('patient_id', $data['patient_id'])->first();
        $salle_attente['etat']='consulter';
        $salle_attente->update(['etat'=>'consulter']);
        // dd($salle_attente);

        return $consultation->load('patient.dossierMedical', 'medecin','service');
    });
}


}