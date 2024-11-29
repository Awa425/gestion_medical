<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateSalleRequest;
use App\Http\Resources\salleResource;
use App\Models\salle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalleController extends BaseController
{

        /**
     * @OA\Get(
     *     path="/api/salles",
     *     summary="liste des salles",
     *     description="Liste de tous les salles.",
     *     operationId="listSalles",
     *     tags={"salles"},
     *     security={{"sanctumAuth":{}}},
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
            $salles = Salle::with('service')->get();
            return response()->json($salles);
        }
    
        /**
 * @OA\Post(
 *      path="/api/salles",
 *      operationId="createSalle",
 *      tags={"salles"},
 *      summary="Créer un nouveau salle",
 *      description="Enregistre un nouveau salle dans la base de données.",
 *      security={{"bearerAuth":{}}},  
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Salle")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Salle")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|unique:salles',
            'capacite' => 'required|integer|min:1',
            'service_id' => 'required|exists:services,id',
        ]);

        $salle = Salle::create($validated);

        return response()->json(['message' => 'Salle créée avec succès', 'salle' => $salle], 201);
    }

/**
 * @OA\Get(
 *      path="/api/salles/{id}",
 *      operationId="GetOneSalleAdmission",
 *      tags={"salles"},
 *      summary="Get One by Id",
 *      description="Afficher les infos d'une salle admission.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la salle à afficher",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Salle trouvé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Salle trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Salle")
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
  *     @OA\Response(
 *         response=404,
 *         description="Salle non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Salle non trouvé")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        $salle = Salle::with('service')->findOrFail($id);
        return response()->json($salle);
    }
   
 

    /**
 * @OA\Put(
 *      path="/api/salles/{id}",
 *      operationId="updateSalles",
 *      tags={"salles"},
 *      summary="Modifier les infos d'une salle",
 *      description="Modifier les infos d'une salle.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la salle à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Salle")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="Salle mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Salle mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Salle")
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
 *     @OA\Response(
 *         response=404,
 *         description="Salle non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Salle non trouvé")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|unique:salles,nom,' . $id,
            'capacite' => 'sometimes|required|integer|min:1',
            'service_id' => 'sometimes|required|exists:services,id',
            'disponible' => 'sometimes|required|boolean',
        ]);

        $salle = Salle::findOrFail($id);
        $salle->update($validated);

        return response()->json(['message' => 'Salle mise à jour avec succès', 'salle' => $salle]);
    }

    public function destroy($id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();

        return response()->json(['message' => 'Salle supprimée avec succès']);
    }
   
}
