<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Services\AdmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function __construct(private AdmissionService $admissionService){}

/**
 * @OA\Post(
 *      path="/api/patients/addAdmission",
 *      operationId="crateAdmissionPatient",
 *      tags={"dossier_medical & Consultation"},
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
        $validatedData = $request->validate([
            'dossierMedical_id' => 'required|exists:dossier_medicals,id',
            'service_id' => 'required|exists:services,id',
            'motif_admission' => 'required|string',
        ]);

        $admission = $this->admissionService->creerAdmission($validatedData);

        return response()->json([
            'message' => 'Admission enregistrée avec succès.',
            'admission' => $admission,
        ], 201);
    }



}
