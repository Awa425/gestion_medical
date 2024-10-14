<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Http\Resources\PersonnelResource;
use App\Models\Certification;
use App\Models\Formation;
use App\Models\Personnel;
use App\Models\Qualification;
use App\Services\PersonnelService;
use App\Utils\FormatData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PersonnelController extends BaseController
{
    public function __construct(protected PersonnelService $personnelService){}

/**
 * @OA\Get(
 *     path="/api/personnels",
 *     summary="liste personnel",
 *     description="Liste de tous les personnels.",
 *     operationId="listPersonnel",
 *     tags={"personnels"},
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
        $personnels = Personnel::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        $personnels->load('type','user','qualifications', 'formations', 'certifications');

        return FormatData::formatResponse(message: 'Liste du personnels', data: $personnels);
    }

/**
 * @OA\Get(
 *     path="/api/medecin-list",
 *     summary="liste des medecins",
 *     description="Liste de tous les medecins.",
 *     operationId="listMedecin",
 *     tags={"personnels"},
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
    public function medecinList()
    {
        $medecins = Personnel::where('type_personnel_id', 1)
        ->get(); 
        $medecins->load('type','user');

        return FormatData::formatResponse(message: 'Liste des medecins', data: $medecins);
    }

/**
 * @OA\Post(
 *      path="/api/personnels",
 *      operationId="createPersonnel",
 *      tags={"personnels"},
 *      summary="Créer un nouveau membre du personnel",
 *      description="Enregistre un nouveau membre du personnel dans la base de données.",
 *      security={{"bearerAuth":{}}},  
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Personnel")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Personnel")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'prenom' => 'required',
            'telephone' => 'nullable',
            'datte_naissance' => 'nullable',
            'lieu_naissance' => 'nullable',
            'adresse' => 'nullable',
            'matricule' => 'nullable',
            'CNI' => 'nullable',
            'datte_embauche' => 'date',
            'type_personnel_id' => 'exists:type_personnels,id',
        ]);

        if($validator->fails()){
            return response()->json(['Error' => 'Erreur de validation'], 404);      
        }

        $personnel = $this->personnelService->createPersonnelWithDetails([
            'personnel' => $request->only([
                'name', 
                'prenom', 
                'datte_naissance', 
                'lieu_naissance', 
                'adresse', 
                'telephone', 
                'email', 
                'CNI', 
                'matricule', 
                'date_embauche',
                'type_personnel_id'
            ]), 
            'user' => $request->get('user'),
            'qualifications' => $request->get('qualifications'),
            'formations' => $request->get('formations'),
            'certifications' => $request->get('certifications'),
        ]);  

        return response()->json([
            'message' => 'Personnel créé avec succès.',
            'personnel' => $personnel,
        ], 201);
    }

/**
 * @OA\Put(
 *      path="/api/personnels/{id}",
 *      operationId="updatePersonnel",
 *      tags={"personnels"},
 *      summary="Modifier les infos d'un membre du personnel",
 *      description="Modifier les infos d'un membre du personnel.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Personnel")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Personnel mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Personnel")
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
 *         description="Utilisateur non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Utilisateur non trouvé")
 *         )
 *     )
 * )
 */
    public function update(Request $request, Personnel $personnel)
    {
       // Utiliser le service pour gérer la logique de mise à jour
       $updatedPersonnel = $this->personnelService->updatePersonnelWithDetails($personnel, [
        'personnel' => $request->only([
            'name', 
            'prenom', 
            'datte_naissance', 
            'lieu_naissance', 
            'adresse', 
            'telephone', 
            'email', 
            'CNI', 
            'matricule', 
            'date_embauche',
            'type_personnel_id'
        ]),
        'user' => $request->get('user'),
        'qualifications' => $request->get('qualifications'),
        'formations' => $request->get('formations'),
        'certifications' => $request->get('certifications'),
    ]);

    return response()->json([
        'message' => 'Personnel mis à jour avec succès.',
        'personnel' => $updatedPersonnel,
    ], 200);
    }

/**
 * @OA\Get(
 *      path="/api/personnels/{id}",
 *      operationId="GetOnePersonnel",
 *      tags={"personnels"},
 *      summary="Get One by Id",
 *      description="Afficher les infos d'un personnel.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur à afficher",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Personnel trouvé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Personnel trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Personnel")
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
 *             @OA\Property(property="message", type="string", example="Personnel non trouvé")
 *         )
 *     )
 * )
 */
    public function show(string $id)
    {
         $personnel = Personnel::find($id);
  
        if (is_null($personnel)) {
            return $this->sendError('Personnel not found.');
        }

        return $personnel->load('user','qualifications', 'formations', 'certifications');

    }

/**
 * @OA\Delete(
 *      path="/api/personnels/{id}",
 *      operationId="delete",
 *      tags={"personnels"},
 *      summary="Activer ou Desactiver un personnel",
 *      description="Activer ou Desactiver un personnel.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur à archiver ou restaurer",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Etat personnel changée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Personnel trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Personnel")
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
 *             @OA\Property(property="message", type="string", example="Personnel non trouvé")
 *         )
 *     )
 * )
 */
    public function destroy(Request $request, Personnel $personnel)
    {
        $personnel->update([
            'isActive' => !$personnel->isActive,
        ]);
        return response()->json([
            'message' => $personnel->isActive ? 'Désactiver avec succès' : 'Restaurer avec succès',
            'data' => $personnel
        ], 200);
      
    }
}
