<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\SalleAttente;
use App\Services\SalleAttenteService;
use App\Utils\FormatData;
use Illuminate\Http\Request;

class SalleAttenteController extends BaseController

{
    public function __construct( protected SalleAttenteService $salleAttenteService) {}
  /**
 * @OA\Get(
 *     path="/api/listSalleAttente",
 *     summary="liste patients",
 *     description="Liste de tous les patients dans la salle d'attente.",
 *     operationId="listPatientsEnAttenteTest",
 *     tags={"salle_attente"},
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

public function listSalleAttente()
{    
        $patients = SalleAttente::with(['patient', 'service'])
        ->where('etat', 'en attente')
        ->get();
        $patients;
        return FormatData::formatResponse(message: 'Liste des patients dans en attente', data: $patients);
}

    /**
 * @OA\Get(
 *     path="/api/salle-attente/service/{id}",
 *     summary="Salle attente by service",
 *     description="Salle attente by service.",
 *     operationId="salleAttenteByService",
 *     tags={"salle_attente"},
 *    @OA\Parameter(
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
public function salleAttenteByService($service_id)
{
    $salle_attente = SalleAttente::where('service_id', $service_id)
    ->get(); 
    $salle_attente->load('service');

    return FormatData::formatResponse(message: 'Liste des medecins dans une salle d\'attente specifiée', data: $salle_attente);
}
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'service_id' => 'required|exists:services,id',
        ]);

        $patient = Patient::where('nom', $validatedData['nom'])
            ->where('prenom', $validatedData['prenom'])
            ->first();

        if (!$patient) {
            $patient = Patient::create([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
            ]);
        }

        $this->salleAttenteService->addPatientToWaitingRoom([
            'patient_id' => $patient->id,
            'service_id' => $validatedData['service_id'],
        ]);

        return response()->json(['message' => 'Patient ajouté à la salle d\'attente.'], 201);
    }
}

