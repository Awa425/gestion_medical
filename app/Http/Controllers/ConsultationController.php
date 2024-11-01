<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use App\Models\Patient;
use App\Services\ConsultationService;
use App\Services\PatientService;
use App\Utils\FormatData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends BaseController
{

    public function __construct(protected PatientService $patientService, protected ConsultationService $consultationService){}
/**
 * @OA\Get(
 *     path="/api/consultations",
 *     summary="liste consultation",
 *     description="Liste de tous les consultations.",
 *     operationId="listConsultation",
 *     tags={"dossier_medical & Consultation"},
 *     @OA\Response(
 *         response=200,
 *         description="Données récupérées avec succès.",
 *         @OA\JsonContent(type="object", @OA\Property(property="data", type="string"))
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
public function index()
{
            
            $consultations = Consultation::with(['patient.dossierMedical', 'medecin','service'])
            ->orderBy('id','desc')
            ->get();
            return FormatData::formatResponse(message: 'Liste des consultations', data: $consultations);
    
}



/**
 * @OA\Post(
 *      path="/api/patients/create-consultation",
 *      operationId="consulterPatient",
 *      tags={"dossier_medical & Consultation"},
 *      summary="Consulter, mettre a jour dossier patient",
 *      description="Consulter et modifier dossier medical d'un patient.", 
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Consultation")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Consultation")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
public function consulterPatient(Request $request)
{
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'medecin_id' => 'required|exists:personnels,id',
        'service_id' => 'required|exists:services,id',
        'notes' => 'nullable|string',
        'libelle' => 'nullable|string',
        'dossierMedical.numero_dossier' => 'nullable|string',
        'dossierMedical.antecedents' => 'nullable|array',
        'dossierMedical.diagnostics' => 'nullable|array',
        'dossierMedical.traitements' => 'nullable|array',
        'dossierMedical.prescriptions' => 'nullable|array',
    ]);

    $consultation = $this->consultationService->createConsultation([
        'patient_id' => $validatedData['patient_id'],
        'medecin_id' => $validatedData['medecin_id'],
        'service_id' => $validatedData['service_id'],
        'notes' => $validatedData['notes'] ?? null,
        'libelle' => $validatedData['libelle'] ?? null,
        'dossierMedical' => $request->get('dossierMedical')
    ]);

    return response()->json([
        'message' => 'Consultation créée avec succès.',
        'consultation' => $consultation,
    ], 201);
}

/**
 * @OA\Put(
 *      path="/api/patients/consultation/{id}/update",
 *      operationId="updateConsultation",
 *      tags={"dossier_medical & Consultation"},
 *      summary="Modifier les infos d'une consultation",
 *      description="Modifier les infos d'une consultation.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID consultation à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Consultation")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Personnel mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Consultation")
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
public function updateConsultation(Request $request, $id)
{
    $validatedData = $request->validate([
        'patient_id' => 'nullable|exists:patients,id',
        'medecin_id' => 'nullable|exists:personnels,id',
        'service_id' => 'nullable|exists:services,id',
        'notes' => 'nullable|string',
        'libelle' => 'nullable|string',
        'dossierMedical.numero_dossier' => 'nullable|string',
        'dossierMedical.antecedents' => 'nullable|array',
        'dossierMedical.diagnostics' => 'nullable|array',
        'dossierMedical.traitements' => 'nullable|array',
        'dossierMedical.prescriptions' => 'nullable|array',
    ]);

    $consultation = $this->consultationService->updateConsultation($id, $validatedData);

    return response()->json([
        'message' => 'Consultation mise à jour avec succès.',
        'consultation' => $consultation,
    ], 200);
}



    public function store(Request $request)
    { 

        
        // Appel au service pour créer la consultation avec le patient
        $consultation = $this->consultationService->createOrUpdateConsultation([
            'patient' => $request->get('patient'),
            'patient_id' => $request->get('patient_id'), // Si le patient existe
            'dossierMedical' => $request->get('dossierMedical'),
            'consultation' => $request->get('consultation'),
        ]);

        return response()->json([
            'message' => 'Consultation créée avec succès.',
            'consultation' => $consultation,
        ], 201);
}

   

    public function show(string $id)
    {
        $consultation = Consultation::find($id);
  
        if (is_null($consultation)) {
            return $this->sendError('Specialite not found.');
        }
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation retrieved successfully.');
    }



    public function update(ConsultationRequest $request, Consultation $consultation)
    {
        $consultation->update($request->validated());

        $consultation->save();
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation updated successfully.');
    }

}
