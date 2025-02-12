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
     * @OA\Get(
     *      path="/api/salle/service/{id}",
     *      operationId="GetSaleesByService",
     *      tags={"salles"},
     *      summary="Get salles by service",
     *      description="Afficher les infos des salles d'une service.",
     *      security={{"bearerAuth":{}}},  
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Id de la service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel trouvé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Salles trouvé avec succès"),
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
    *         description="Personnel non trouvé",
    *         @OA\JsonContent(
    *             @OA\Property(property="status", type="string", example="error"),
    *             @OA\Property(property="message", type="string", example="Salles non trouvé")
    *         )
    *     )
    * )
    */
        public function salleByService($serviceId)
        {
        $saleByService = Salle::with('service')
        ->where('service_id', $serviceId)
        ->orderBy('id', 'DESC')
        ->get();
        return response()->json($saleByService);
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
            'type' => 'required|string', 

        ]);

        $salle = Salle::create($validated);
        $salle->lits_restants=$request->capacite;
        $salle->save();

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
    // Récupérer la salle existante
    $salle = Salle::findOrFail($id);

    // Initialiser les valeurs actuelles
    $ancienneCapacite = $salle->capacite;
    $litsOccupes = $salle->capacite - $salle->lits_restants;

    // Vérifier si la requête contient une modification de la capacité
    if ($request->has('capacite')) {
        $nouvelleCapacite = $request->input('capacite');

        // Valider que la nouvelle capacité est suffisante pour les lits occupés
        if ($nouvelleCapacite < $litsOccupes) {
            return response()->json([
                'message' => "La nouvelle capacité ($nouvelleCapacite) ne peut pas être inférieure au nombre de lits occupés ($litsOccupes).",
            ], 400);
        }

        // Mettre à jour les lits restants
        $salle->lits_restants += ($nouvelleCapacite - $ancienneCapacite);

        // Mettre à jour la capacité
        $salle->capacite = $nouvelleCapacite;
    }

    // Vérifier si un autre champ doit être mis à jour (comme le nom)
    if ($request->has('nom')) {
        $salle->nom = $request->input('nom');
    }
    if ($request->has('service_id')) {
        $salle->service_id = $request->input('service_id');
    }

    // Sauvegarder les modifications
    $salle->save();

    return response()->json([
        'message' => 'Salle mise à jour avec succès.',
        'salle' => $salle,
    ], 200);
}

    public function destroy($id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();

        return response()->json(['message' => 'Salle supprimée avec succès']);
    }
   
}
