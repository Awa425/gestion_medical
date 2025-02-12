<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Services\RendezVousService;
use App\Utils\FormatData;
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
 *      security={{"bearerAuth":{}}},
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
    return response()->json($rv->load('service','medecin','patient'));
}

 /**
 * @OA\Post(
 *      path="/api/rendezVous",
 *      operationId="crateRendezVous",
 *      tags={"rendez-vous"},
 *      summary="Créer un nouveau rendez-vous",
 *      description="Créer un nouveau rendez-vous.",
 *      security={{"bearerAuth":{}}},
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
 * @OA\Get(
 *      path="/api/rendezVous/{id}",
 *      operationId="GetOneRendezVous",
 *      tags={"rendez-vous"},
 *      summary="Get One rendez-vous by Id",
 *      description="Afficher les infos d'un rendez-vous.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du rendez-vous à afficher",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Personnel trouvé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Rendez-vous trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/RendezVous")
 *      )
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
 *         description="Rendez vous non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Rendez vous non trouvé")
 *         )
 *      )
 * )
 */    
public function show($id){
   $rv = RendezVous::with('patient','medecin','service')->findOrFail($id);
   return response()->json(['rendez-vous' => $rv], 200);

}

/**
 * @OA\Get(
 *      path="/api/rendezVous/patient/{patient_id}",
 *      operationId="GetRendezVousByPatient",
 *      tags={"rendez-vous"},
 *      summary="Liste des rendez-vous d'un patient",
 *      description="Liste des rendez-vous d'un patient",
*      security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="patient_id",
 *         in="path",
 *         required=true,
 *         description="ID du patient",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Liste rendez-vous ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Patient trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/RendezVous")
 *         ),
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
 *         description="Rendey vous trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Rendey vous trouvé")
 *         )
 *     )
 * )
 */
public function listRendezVousByPatient($patientId){
    $rv= RendezVous::with('patient','medecin','service')
    ->where('patient_id', $patientId)
    ->get();
    return response()->json($rv, 200);

}

/**
 * @OA\Get(
 *      path="/api/rendezVous/medecin/{medecin_id}",
 *      operationId="GetRendezVousByMedecin",
 *      tags={"rendez-vous"},
 *      summary="Liste des rendez-vous d'un medecin",
 *      description="Liste des rendez-vous d'un medecin",
 *      security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="medecin_id",
 *         in="path",
 *         required=true,
 *         description="ID du medecin",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Liste rendez-vous ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="medecin trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/RendezVous")
 *         ),
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
 *         description="Rendey vous trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Rendey vous trouvé")
 *         )
 *     )
 * )
 */
public function listRendezVousByMedecin($medecinId){
    $rv= RendezVous::with('patient','medecin','service')
    ->where('medecin_id', $medecinId)
    ->get();
    return response()->json($rv, 200);

    // return FormatData::formatResponse(message: 'Liste des rendez vous', data: $rv);

}

/**
 * @OA\Put(
 *      path="/api/annuler/rendezVous/{id}",
 *      operationId="updaterendezVous",
 *      tags={"rendez-vous"},
 *      summary="Annuler rendez-vous",
 *      description="Annuler rendez-vous.", 
 *      security={{"bearerAuth":{}}},
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
 * )
 */
public function annuler($id)
{
    $this->rendezVousService->annulerRendezVous($id);
    return response()->json(['message' => 'Rendez-vous annulé avec succès']);
}
}
