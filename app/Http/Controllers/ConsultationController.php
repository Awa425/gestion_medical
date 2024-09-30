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

   

        /**
     * Display the specified resource.
     */
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
