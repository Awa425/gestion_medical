<?php

namespace App\Http\Controllers;

use App\Services\RendezVousService;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
   

    public function __construct(protected RendezVousService $rendezVousService){}

    // Créer un nouveau rendez-vous
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:personnels,id',
            'date_heure' => 'required|date_format:Y-m-d H:i:s',
            'motif' => 'nullable|string',
        ]);

        try {
            $rendezVous = $this->rendezVousService->creerRendezVous($validatedData);
            return response()->json(['message' => 'Rendez-vous créé avec succès', 'rendez_vous' => $rendezVous], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Annuler un rendez-vous
    public function annuler($id)
    {
        $this->rendezVousService->annulerRendezVous($id);
        return response()->json(['message' => 'Rendez-vous annulé avec succès']);
    }
}
