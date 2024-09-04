<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use App\Utils\FormatData;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService){}


    public function index()
    {
        $patients = Patient::all();
        return FormatData::formatResponse(message: 'Liste des patients', data: $patients);
    }
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

        $patient = $this->patientService->createPatient([
            'patient' => $request->only([
                'nom', 
                'prenom', 
                'date_naissance', 
                'adresse', 
                'telephone', 
                'email', 
                'sexe', 
                'groupe_sanguin', 
            ]), 
            'dossierMedical' => $request->get('dossierMedical'),
        ]);

        return response()->json([
            'message' => 'Patient créé avec succès.',
            'patient' => $patient,
        ], 201);
    }

    public function update(Request $request, Patient $patient)
    {
        // Mise à jour du patient (et création ou mise à jour du dossier médical si fourni)
        $updatePatient = $this->patientService->updatePatient($patient,[
            'patient' => $request->only([
                'nom', 
                'prenom', 
                'date_naissance', 
                'adresse', 
                'telephone', 
                'email',
                'sexe',
                'groupe_sanguin'
            ]),
            'dossierMedical' => $request->get('dossierMedical')
        ]);
    
        return response()->json([
            'message' => 'Patient mis à jour avec succès.',
            'patient' => $updatePatient,
        ], 200);   
    }

    public function show($id)
    {
        $patient = $this->patientService->getPatientWithMedicalRecord($id);
        return response()->json(['patient' => $patient], 200);
    }

}
