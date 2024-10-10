<?php

namespace App\Http\Controllers;

use App\Services\TransfertService;
use Illuminate\Http\Request;

class TransfereController extends Controller
{
    public function __construct(private TransfertService $transfertService){}

    /**
 * @OA\Post(
 *      path="/api/patients/addTransfert",
 *      operationId="crateTransfertPatient",
 *      tags={"dossier_medical"},
 *      summary="Transfert de patients",
 *      description="Faire un transfert de patient.",
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/transfert")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/transfert")
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
            'from_service_id' => 'required|exists:services,id',
            'to_service_id' => 'required|exists:services,id',
            'motif_transfert' => 'required|string',
        ]);

        $transfert = $this->transfertService->creerTransfert($validatedData);

        return response()->json([
            'message' => 'Transfert enregistré avec succès.',
            'transfert' => $transfert,
        ], 201);
    }
}
