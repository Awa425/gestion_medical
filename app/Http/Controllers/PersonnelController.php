<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Http\Resources\PersonnelResource;
use App\Models\Certification;
use App\Models\Disponibilite;
use App\Models\Formation;
use App\Models\Personnel;
use App\Models\Qualification;
use App\Services\PersonnelService;
use App\Utils\FormatData;
use Carbon\Carbon;
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
        $personnels = Personnel::orderBy('id', 'DESC')
        ->get();
        $personnels->load('type','user.roles','service','qualifications', 'formations', 'certifications');

        return FormatData::formatResponse(message: 'Liste du personnels', data: $personnels);
    }

/**
 * @OA\Get(
 *     path="/api/medecin-list",
 *     summary="liste des medecins",
 *     description="Liste de tous les medecins.",
 *     operationId="listMedecin",
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
public function medecinList()
{
    $medecins = Personnel::where('type_personnel_id', 1)
    ->get(); 
    $medecins->load('type','user.roles');

    return FormatData::formatResponse(message: 'Liste des medecins', data: $medecins);
}

/**
 * @OA\Get(
 *     path="/api/medecins/service/{id}",
 *     summary="liste des medecins dans un service",
 *     description="Liste de tous les medecins dans un service.",
 *     operationId="listMedecinByService",
 *      security={{"bearerAuth":{}}},
 *     tags={"personnels"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID service",
 *         @OA\Schema(type="integer")
 *     ),
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
public function medecinsByService($id_service)
{
    $medecins = Personnel::where('service_id', $id_service)
    ->get(); 
    $medecins->load('type','user.roles','service');

    return FormatData::formatResponse(message: 'Liste des medecins dans un service donné', data: $medecins);
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
        'service_id'=>'exists:services,id'
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
            'type_personnel_id',
            'service_id',
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
 *      security={{"bearerAuth":{}}},  
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
            'type_personnel_id',
            'service_id'
        ]),
        'user' => $request->get('user.roles'),
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

        return $personnel->load('user.roles','qualifications', 'formations', 'certifications');

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

    /**
 * @OA\Post(
 *     path="/api/disponibilites",
 *     summary="Enregistrer les disponibilités d'un médecin",
 *     tags={"Disponibilites"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"medecin_id", "date", "heures"},
 *             @OA\Property(property="medecin_id", type="integer", example=1),
 *             @OA\Property(property="date", type="string", format="date", example="2025-03-11"),
 *             @OA\Property(property="heures", type="array",
 *                 @OA\Items(type="string", format="time", example="09:00")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Disponibilités enregistrées"),
 *     @OA\Response(response=400, description="Données invalides")
 * )
 */
    public function ajoutCreneauxHoraire(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:personnels,id',
            'date' => 'required|date',
            'heures' => 'required|array', // Tableau d'heures
            'heures.*' => 'date_format:H:i', // Vérifie que chaque heure est bien formatée
        ]);
        // dd('ok');
        foreach ($validated['heures'] as $heure) {
            Disponibilite::updateOrCreate(
                ['medecin_id' => $validated['medecin_id'], 'date' => $validated['date'], 'heure' => $heure],
                ['est_disponible' => true]
            );
        }

        return response()->json(['message' => 'Créneaux horaire enregister'], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/creneaux/generer",
     *     summary="Générer automatiquement les créneaux horaires d'un médecin",
     *     tags={"Disponibilites"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"medecin_id", "date", "heure_debut", "heure_fin", "intervalle"},
     *             @OA\Property(property="medecin_id", type="integer", example=1),
     *             @OA\Property(property="date", type="string", format="date", example="2025-03-11"),
     *             @OA\Property(property="heure_debut", type="string", format="time", example="08:00"),
     *             @OA\Property(property="heure_fin", type="string", format="time", example="18:00"),
     *             @OA\Property(property="intervalle", type="integer", example=30)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Créneaux générés avec succès"),
     *     @OA\Response(response=400, description="Données invalides")
     * )
     */
    public function genererDisponibilites(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:personnels,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'intervalle' => 'required|integer|min:10'
        ]);

        $debut = Carbon::parse($validated['heure_debut']);
        $fin = Carbon::parse($validated['heure_fin']);
        $intervalle = $validated['intervalle'];
        
        $heures = [];
        while ($debut->lessThan($fin)) {
            $heures[] = $debut->format('H:i');
            $debut->addMinutes($intervalle);
        }

        foreach ($heures as $heure) {
            Disponibilite::updateOrCreate(
                ['medecin_id' => $validated['medecin_id'], 'date' => $validated['date'], 'heure' => $heure],
                ['est_disponible' => true]
            );
        }

        return response()->json(['message' => 'Créneaux générés avec succès', 'heures' => $heures], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/disponibilites",
     *     summary="Heures disponible pour un medecin",
     *     description="Liste des heure disponible pour un medecin.",
     *     operationId="creneaux horaire",
     *      security={{"bearerAuth":{}}},
     *     tags={"Disponibilites"},
 *     @OA\Parameter(
 *         name="date",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", format="date", example="2025-03-11")
 *     ),
 *     @OA\Parameter(
 *         name="medecin_id",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
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
    public function getHorairesDisponibles(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'medecin_id' => 'required|exists:personnels,id'
        ]);
    
        $disponibilites = Disponibilite::where('medecin_id', $validated['medecin_id'])
                            ->where('date', $validated['date'])
                            ->where('est_disponible', true)
                            ->pluck('heure');
    
        return response()->json(['horaires' => $disponibilites]);
    }

    /**
     * @OA\Put(
     *     path="/api/creneaux/{id}",
     *     summary="Modifier un créneau généré",
     *     tags={"Disponibilites"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du créneau à modifier",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"date", "heure", "est_disponible", "medecin_id"},
     *             @OA\Property(property="date", type="string", format="date", example="2025-03-11"),
     *             @OA\Property(property="heure", type="string", format="time", example="10:00"),
     *             @OA\Property(property="est_disponible", type="boolean", example=true),
     *             @OA\Property(property="medecin_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Créneau modifié avec succès"),
     *     @OA\Response(response=404, description="Créneau non trouvé"),
     *     @OA\Response(response=422, description="Un créneau existe déjà pour cette date et heure")
     * )
     */


    public function modifierCreaneau(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'date' => 'date',
            'heure' => 'date_format:H:i',
            'est_disponible' => 'boolean',
            'medecin_id' => 'exists:personnels,id', // S'assurer que le médecin existe
        ]);

        // Vérifier si le créneau existe
        $creneau = Disponibilite::find($id);
        if (!$creneau) {
            return response()->json(['message' => 'Créneau non trouvé'], 404);
        }

        // Vérifier si un autre créneau existe déjà pour ce médecin à la même date et heure
        $existe = Disponibilite::where('medecin_id', $validated['medecin_id'])
            ->where('date', $validated['date'])
            ->where('heure', $validated['heure'])
            ->where('id', '!=', $id) // Exclure le créneau en cours de modification
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'Un créneau existe déjà pour cette date et heure'], 422);
        }

        // Mise à jour du créneau
        $creneau->update($validated);

        return response()->json([
            'message' => 'Créneau modifié avec succès',
            'creneau' => $creneau
        ]);
            }

}
