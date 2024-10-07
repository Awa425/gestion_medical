<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use App\Models\Patient;
use App\Services\ConsultationService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends BaseController
{

    public function __construct(protected PatientService $patientService, protected ConsultationService $consultationService){}

    public function index()
    {
        $consultation = Consultation::all();
    
        return $this->sendResponse(ConsultationResource::collection($consultation), 'Consultation retrieved successfully.');
    }

    /**
 * @OA\Post(
 *      path="/api/patients/create-consultation",
 *      operationId="consulterPatient",
 *      tags={"patients"},
 *      summary="Consulter un patient",
 *      description="Consulter un patient.", 
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
        'notes' => $validatedData['notes'] ?? null,
        'dossierMedical' => $request->get('dossierMedical')
    ]);

    return response()->json([
        'message' => 'Consultation créée avec succès.',
        'consultation' => $consultation,
    ], 201);
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

        /**
     * Update the specified resource in storage.
     */
    public function update(ConsultationRequest $request, Consultation $consultation)
    {
        $consultation->update($request->validated());

        $consultation->save();
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation updated successfully.');
    }

}
