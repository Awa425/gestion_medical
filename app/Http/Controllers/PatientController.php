<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService){}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:patients',
            'sexe' => 'nullable|in:M,F',
            'groupe_sanguin' => 'nullable|string|max:3',
        ]);

        $patient = $this->patientService->createPatient($validatedData);

        return response()->json(['patient' => $patient], 201);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:patients,email,' . $patient->id,
            'sexe' => 'nullable|in:M,F',
            'groupe_sanguin' => 'nullable|string|max:3',
        ]);

        $patient = $this->patientService->updatePatient($patient, $validatedData);

        return response()->json(['patient' => $patient], 200);
    }

    public function show($id)
    {
        $patient = $this->patientService->getPatientWithMedicalRecord($id);
        return response()->json(['patient' => $patient], 200);
    }

}
