<?php
namespace App\Services;

use App\Models\DossierMedical;

class DossierMedicalService{
    
    public function createDossierMedical(array $data)
    {
        return DossierMedical::create($data);
    }

    public function updateDossierMedical(DossierMedical $dossier, array $data)
    {
        $dossier->update($data);
        return $dossier;
    }

    public function getDossierMedical($id)
    {
        return DossierMedical::with('patient')->findOrFail($id);
    }

    public function deleteDossierMedical(DossierMedical $dossier)
    {
        $dossier->delete();
    }
}