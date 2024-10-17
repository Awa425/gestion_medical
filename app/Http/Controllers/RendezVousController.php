<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Services\RendezVousService;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
   

    public function __construct(protected RendezVousService $rendezVousService){}
    /**
 * @OA\Get(
 *     path="/api/rendezVous",
 *     summary="liste des rendezVous",
 *     description="Liste des rendezVous.",
 *     operationId="listRendezVous",
 *     tags={"rendez-vous"},
 *     @OA\Response(
 *         response=200,
 *         description="Données récupérées avec succès.",
 *         @OA\JsonContent(type="object", @OA\Property(property="data", type="string"))
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé, token invalide ou manquant."
 *     )
 * )
 */
public function index()
{
    $rv=RendezVous::all();
    return response()->json($rv);
}

 /**
 * @OA\Post(
 *      path="/api/rendezVous",
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

/**
 * @OA\Put(
 *      path="/api/annuler/rendezVous/{id}",
 *      operationId="updaterendezVous",
 *      tags={"rendez-vous"},
 *      summary="Annuler rendez-vous",
 *      description="Annuler rendez-vous.", 
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du RV",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="RV mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Rendez-vous annuler"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/RendezVous")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Requête invalide",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     ),
 * )
 */
    public function annuler($id)
    {
        $this->rendezVousService->annulerRendezVous($id);
        return response()->json(['message' => 'Rendez-vous annulé avec succès']);
    }
}
