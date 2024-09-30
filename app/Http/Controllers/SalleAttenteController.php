<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\SalleAttenteService;
use Illuminate\Http\Request;

class SalleAttenteController extends Controller
{
  

    public function __construct( protected SalleAttenteService $salleAttenteService) {}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'service_id' => 'required|exists:services,id',
        ]);

        // Vérifiez si le patient existe
        $patient = Patient::where('nom', $validatedData['nom'])
            ->where('prenom', $validatedData['prenom'])
            ->first();

        if (!$patient) {
            // Si le patient n'existe pas, vous pouvez l'ajouter ici.
            // Vous pouvez également utiliser la logique d'ajout de patient existante.
            $patient = Patient::create([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                // Autres champs...
            ]);
        }

        // Ajouter le patient à la salle d'attente
        $this->salleAttenteService->addPatientToWaitingRoom([
            'patient_id' => $patient->id,
            'service_id' => $validatedData['service_id'],
        ]);

        return response()->json(['message' => 'Patient ajouté à la salle d\'attente.'], 201);
    }
}

