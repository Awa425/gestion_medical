<?php
namespace App\Services;

use App\Models\Patient;

class PatientService{
    public function createPatient(array $data)
    {
        return Patient::create($data);
    }

    public function updatePatient(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }

    public function getPatientWithMedicalRecord($id)
    {
        return Patient::with('dossierMedical')->findOrFail($id);
    }
}