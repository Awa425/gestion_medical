<?php

namespace App\Http\Controllers;

use App\Models\Admission;
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
     *     tags={"dossier_medical & Consultation"},
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
     *     tags={"dossier_medical & Consultation"},
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
 
     $dossierMedicalId = $validatedData['dossierMedical_id'];

     $admissionExistante = Admission::where('dossierMedical_id', $dossierMedicalId)
         ->where('etat_admission', '!=', 'termine') 
         ->exists();
 
     if ($admissionExistante) {
         return response()->json([
             'message' => 'Impossible de créer une nouvelle admission car le patient a déjà une admission en cours.',
         ], 400);
     }
 
     $admission = $this->admissionService->creerAdmission($validatedData);
 
     return response()->json([
         'message' => 'Admission enregistrée avec succès.',
         'admission' => $admission,
     ], 201);
 }
 



}
