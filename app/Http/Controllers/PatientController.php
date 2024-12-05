<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\SalleAttente;
use App\Services\PatientService;
use App\Utils\FormatData;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService){}

/**
 * @OA\Get(
 *     path="/api/patients-dossiers",
 *     summary="liste patients",
 *     description="Liste de tous les patients avec leurs dossier medical.",
 *     operationId="listPatientsDossier",
 *     tags={"patients"},
 *     security={{"sanctumAuth":{}}},
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
public function getPatientWithMedical()
{
    return Patient::with('dossierMedical','consultations','dossierMedical.admissions','dossierMedical.transferts')->get();
}

/**
 * @OA\Get(
 *     path="/api/patients",
 *     summary="liste patients",
 *     description="Liste de tous les patients.",
 *     operationId="listPatients",
 *     tags={"patients"},
 *     security={{"sanctumAuth":{}}},
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
public function listPatients()
{   
    $patients = Patient::all();
    return FormatData::formatResponse(message: 'Liste des patients', data: $patients);
}

/**
 * @OA\Get(
 *      path="/api/patients/enAttente/services/{service_id}",
 *      operationId="GetPatientByService",
 *      tags={"salle_attente"},
 *      summary="Liste des patient dans en service",
 *      description="Liste des patient dans en service",
 *     @OA\Parameter(
 *         name="service_id",
 *         in="path",
 *         required=true,
 *         description="ID d'un service",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Liste Patients ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Patient trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/SalleAttente")
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
 *         description="Salle attente non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Salle attente non trouvé")
 *         )
 *     )
 * )
 */
public function listSalleAttenteByService($service)
{
        $patients = SalleAttente::with(['patient', 'service'])
        ->where('etat', 'en attente')
        ->where('service_id', $service)
        ->get();
        $patients;
        return FormatData::formatResponse(message: 'Liste des patients dans en attente', data: $patients);
}

/**
 * @OA\Post(
 *      path="/api/patients",
 *      operationId="cratePatient",
 *      tags={"patients"},
 *      summary="Créer un nouveau patient",
 *      description="Créer un nouveau patient.",
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Patient")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Patient")
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
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'date_naissance' => 'required|date',
        'adresse' => 'nullable|string',
        'telephone' => 'nullable|string',
        'email' => 'nullable|email|unique:patients',
        'sexe' => 'nullable|in:M,F',
        'groupe_sanguin' => 'nullable|string|max:3',
        'matricule'=>'required|string'
    ]);

    $patient = $this->patientService->createPatient([
        'patient' => $request->only([
            'nom', 
            'prenom', 
            'date_naissance', 
            'adresse', 
            'telephone', 
            'email', 
            'sexe', 
            'groupe_sanguin', 
            'matricule'
        ]), 
        'dossierMedical' => $request->get('dossierMedical'),
    ]);

    return response()->json([
        'message' => 'Patient créé avec succès.',
        'patient' => $patient,
    ], 201);
}

/**
 * @OA\Post(
 *      path="/api/salleAttente",
 *      operationId="storeWaitingRoom",
 *      tags={"salle_attente"},
 *      summary="Enregistrer dans la salle d'attente",
 *      description="Enregistrer dans la salle d'attente.",
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/SalleAttente")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/SalleAttente")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
public function storeWaitingRoom(Request $request){
    
    try{ $validatedData = $request->validate([
        'nom' => 'nullable|string',
        'prenom' => 'nullable|string',
        'date_naissance' => 'nullable|date',
        'adresse' => 'nullable|string',
        'telephone' => 'nullable|string',
        'email' => 'nullable|email',  
        'matricule' => [
            'required',
            'string',
            // Ignorer le matricule s'il appartient déjà à un patient existant
            Rule::unique('patients')->ignore($request->get('matricule'), 'matricule')
        ],          
        'sexe' => 'nullable|in:M,F',
        'groupe_sanguin' => 'nullable|string|max:3',
        'service_id' => 'required|exists:services,id',
    ]); }
    catch (\Illuminate\Validation\ValidationException $e){
        return response()->json([
        'message' => 'Erreur de validation',
        'erreurs' => $e->errors(),
    ], 422);
    }
    // Appel au service pour enregistrer le patient
    $result = $this->patientService->storeWaitingRoom($validatedData);

    return response()->json([
        'message' => 'Patient enregistré et placé en salle d\'attente.',
        'patient' => $result['patient'],
        'salle_attente' => $result['salle_attente'],
    ], 201);
}

/**
 * @OA\Put(
 *      path="/api/patients/salle_attentes/{id}",
 *      operationId="updatesalle_attentes",
 *      tags={"salle_attente"},
 *      summary="Modifier les infos d'une salle attente",
 *      description="Modifier les infos d'une salle attente.",  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du passagers à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Patient")
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="Depanneur mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Infos salle mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Patient")
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
 *         description="Conducteur non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Utilisateur non trouvé")
 *         )
 *     )
 * )
 */
public function updateWaitingRoom(Request $request, $patientId)
{
    try {
        $validatedData = $request->validate([
            'nom' => 'nullable|string',
            'prenom' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email' => 'nullable|email',
            'matricule' => [
                'required',
                'string',
                Rule::unique('patients')->ignore($patientId),
            ],
            'sexe' => 'nullable|in:M,F',
            'groupe_sanguin' => 'nullable|string|max:3',
            'service_id' => 'required|exists:services,id',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'erreurs' => $e->errors(),
        ], 422);
    }

    $result = $this->patientService->updateWaitingRoom($patientId, $validatedData);

    return response()->json([
        'message' => 'Informations du patient mises à jour avec succès.',
        'patient' => $result['patient'],
        'salle_attente' => $result['salle_attente'],
    ], 200);
}



public function update(Request $request, Patient $patient)
{
    // Mise à jour du patient (et création ou mise à jour du dossier médical si fourni)
    $updatePatient = $this->patientService->updatePatient($patient,[
        'patient' => $request->only([
            'nom', 
            'prenom', 
            'date_naissance', 
            'adresse', 
            'telephone', 
            'email',
            'sexe',
            'groupe_sanguin',
            'matricule'
        ]),
        'dossierMedical' => $request->get('dossierMedical')
    ]);

    return response()->json([
        'message' => 'Patient mis à jour avec succès.',
        'patient' => $updatePatient,
    ], 200);   
}


public function createDossier(Request $request, Patient $patient)
{
// Mise à jour du patient (et création ou mise à jour du dossier médical si fourni)
$updatePatient = $this->patientService->ajouterDossierPatient($patient,[
'patient' => $request->only([
    'nom', 
    'prenom', 
    'date_naissance', 
    'adresse', 
    'telephone', 
    'email',
    'sexe',
    'groupe_sanguin',
    'matricule'
]),
'dossierMedical' => $request->get('dossierMedical')
]);

return response()->json([
'message' => 'Creation dossier avec succes.',
'patient' => $updatePatient,
], 200);   
}

/**
 * @OA\Get(
 *      path="/api/patients/{id}",
 *      operationId="GetOnePatient",
 *      tags={"patients"},
 *      summary="Get One by Id",
 *      description="Afficher les infos d'un patient.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du patient à afficher",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Personnel trouvé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Patient trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Patient")
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
 *         description="Personnel non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Patient non trouvé")
 *         )
 *      )
 * )
 */
public function show($id)
{
    $patient = $this->patientService->getPatientWithMedicalRecord($id);
    return response()->json(['patient' => $patient], 200);
}

/**
 * @OA\Get(
 *      path="/api/detail-complet/patient/{id}",
 *      operationId="detailCompletPatient",
 *      tags={"patients"},
 *      summary="Get detail complet patient",
 *      description="Afficher les infos complet d'un patient.",
 *      security={{"bearerAuth":{}}},  
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du patient à afficher ses detail complet",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Personnel trouvé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Patient trouvé avec succès"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Patient")
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
 *         description="Personnel non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Patient non trouvé")
 *         )
 *      )
 * )
 */
public function detailCompletPatient($id)
{
    $trajet = Patient::with('dossierMedical.admissions.service','dossierMedical.transferts','dossierMedical.admissions.sortie','consultations.service','consultations.medecin')->findOrFail($id);
    return response()->json($trajet);
    
   
}
}
