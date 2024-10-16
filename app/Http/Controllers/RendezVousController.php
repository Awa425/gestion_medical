<?php

namespace App\Http\Controllers;

use App\Services\RendezVousService;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
   

    public function __construct(protected RendezVousService $rendezVousService){}

 /**
 * @OA\Post(
 *      path="/api/ajouter/rendezVous",
 *      operationId="crateRendezVous",
 *      tags={"rendez-vous"},
 *      summary="Créer un nouveau rendez-vous",
 *      description="Créer un nouveau rendez-vous.",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/RendezVous")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/RendezVous")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:personnels,id',
            'service_id' => 'required|exists:services,id',
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
