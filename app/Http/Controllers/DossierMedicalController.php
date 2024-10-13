<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use App\Services\DossierMedicalService;
use Illuminate\Http\Request;

class DossierMedicalController extends Controller
{
    public function __construct(protected DossierMedicalService $dossierService){}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'numero_dossier' => 'required|string',
            'antecedents' => 'nullable|string',
            'diagnostics' => 'nullable|string',
            'traitements' => 'nullable|string',
            'prescriptions' => 'nullable|string',
        ]);

        $dossierMedical = $this->dossierService->createDossierMedical($validatedData);

        return response()->json(['dossierMedical' => $dossierMedical], 201);
    }

    public function update(Request $request, $id)
    {
        $dossierMedical = DossierMedical::findOrFail($id);

        $validatedData = $request->validate([
            'antecedents' => 'nullable|string',
            'diagnostics' => 'nullable|string',
            'traitements' => 'nullable|string',
            'prescriptions' => 'nullable|string',
        ]);

        $dossierMedical = $this->dossierService->updateDossierMedical($dossierMedical, $validatedData);

        return response()->json(['dossierMedical' => $dossierMedical], 200);
    }

    public function show($id)
    {
        $dossierMedical = $this->dossierService->getDossierMedical($id);
        return response()->json(['dossierMedical' => $dossierMedical], 200);
    }

}