<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\salle;
use App\Services\AdmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    public function __construct(private AdmissionService $admissionService){}

        /**
     * @OA\Get(
     *     path="/api/admissions",
     *     summary="liste des admissions",
     *     description="Liste des admissions.",
     *     operationId="listTousLesAdmissions",
     *     tags={"Admission & sortie & transfert"},
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
    $admission = Admission::with('dossierMedical.patient')
    ->orderBy('id', 'DESC')
    ->get();
    return response()->json($admission);
    }

    /**
     * @OA\Post(
     *     path="/api/admissions/en-cours",
     *     summary="Admissions en cours",
     *     description="Recuperer l'admissions en cours du patient",
     *     operationId="AdmissionsEnCours",
     *     tags={"Admission & sortie & transfert"},
     *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(
    *                 property="patient_id",
    *                 type="integer",
    *                 description="ID du patient",
    *                 example=1
    *             ),
    *         )
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
    public function getAdmissionEnCours(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $patientId = $request->patient_id;

        $admissionEnCours = Admission::whereHas('dossierMedical', function ($query) use ($patientId) {
            $query->where('patient_id',$patientId);
        })
        ->with('dossierMedical.patient','service')
        ->where('etat_admission', 'en cours')
        ->first();
        return response()->json($admissionEnCours);
    }    

/**
 * @OA\Post(
 *      path="/api/patients/addAdmission",
 *      operationId="crateAdmissionPatient",
 *      tags={"Admission & sortie & transfert"},
 *      summary="Ajout admission patient",
 *      description="Admission patient.",
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Admission")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Admission")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */

 public function store(Request $request)
 {
     // Validation des données
     $validatedData = $request->validate([
         'dossierMedical_id' => 'required|exists:dossier_medicals,id',
         'service_id' => 'required|exists:services,id',
         'motif_admission' => 'required|string',
         'salle_id' => 'required|exists:salles,id',
     ]);
     $dossierMedicalId = $validatedData['dossierMedical_id'];
     $serviceId = $validatedData['service_id'];
     $salleId = $validatedData['salle_id'];
     
     // Vérification si le patient a déjà une admission en cours
     $admissionExistante = Admission::where('dossierMedical_id', $dossierMedicalId)
         ->where('etat_admission', '!=', 'termine')
         ->exists(); 
 
     if ($admissionExistante) {
         return response()->json([
             'message' => 'Impossible de créer une nouvelle admission car le patient a déjà une admission en cours.',
         ], 400);
     }
    
     // Vérification si la salle appartient au service et est disponible
     $salle = salle::where('id', $salleId)
         ->where('service_id', $serviceId)
         ->first();
 
     if (!$salle) {
         return response()->json([
             'message' => 'La salle sélectionnée n\'appartient pas au service spécifié.',
         ], 400);
     } 
 
     if ($salle->lits_restants <= 0) {
         return response()->json([
             'message' => 'La salle sélectionnée n\'a plus de lits disponibles.',
         ], 400);
     }
     // Création de l'admission
     $admission = $this->admissionService->creerAdmission($validatedData);
 
     // Décrémenter la capacité de la salle
     $salle->decrement('lits_restants');
 
     return response()->json([
         'message' => 'Admission enregistrée avec succès.',
         'admission' => $admission,
     ], 201);
 }
 
 /**
 * @OA\Put(
 *      path="/api/patients/admission/{id}/update",
 *      operationId="updateAdmission",
 *      tags={"Admission & sortie & transfert"},
 *      summary="Modifier les infos d'une admission",
 *      description="Modifier les infos d'une admission.",  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de admission à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Admission")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="Admission mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Infos Admission mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Admission")
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
 *         description="Admission non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Admission non trouvé")
 *         )
 *     )
 * )
 */
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'dossierMedical_id' => 'sometimes|exists:dossier_medicals,id',
        'service_id' => 'sometimes|exists:services,id',
        'salle_id' => 'sometimes|exists:salles,id',
        'motif_admission' => 'sometimes|string',
        'etat_admission' => 'sometimes|in:en cours,termine', 
    ]);

    // Récupérer l'admission à mettre à jour
    $admission = Admission::findOrFail($id);

    // Si une salle est fournie, vérifier qu'elle appartient au service
    if (isset($validatedData['salle_id'])) {
        $salle = Salle::findOrFail($validatedData['salle_id']);
        $serviceId = $validatedData['service_id'] ?? $admission->service_id;

    // Vérifier si l'admission est terminée
    if ($admission->etat_admission === 'termine') {
        return response()->json([
            'message' => 'Impossible de modifier une admission ayant un état terminé.',
        ], 400);
    }

        // Vérifier si la salle appartient bien au service
        if ($salle->service_id != $serviceId) {
            return response()->json([
                'message' => 'La salle sélectionnée n\'appartient pas au service spécifié.',
            ], 400);
        }

        // Vérifier si la capacité de la salle permet d'ajouter un lit
        if ($salle->lits_restants <= 0 && $admission->salle_id != $salle->id) {
            return response()->json([
                'message' => 'La salle sélectionnée est pleine.',
            ], 400);
        }

        // Si une nouvelle salle est attribuée, ajuster les capacités
        if ($admission->salle_id && $admission->salle_id != $salle->id) {
            // Rendre la capacité à l'ancienne salle
            $ancienneSalle = Salle::find($admission->salle_id);
            if ($ancienneSalle) {
                $ancienneSalle->lits_restants += 1;
                $ancienneSalle->save();
            }

            // Réduire la capacité de la nouvelle salle
            $salle->lits_restants -= 1;
            $salle->save();
        }
    }

    // Mise à jour des champs
    $admission->update($validatedData);

    return response()->json([
        'message' => 'Admission mise à jour avec succès.',
        'admission' => $admission->load('dossierMedical', 'service','salle'),
    ]);
}





}
