<?php

namespace App\Http\Controllers;

use App\Models\Transfere;
use App\Services\TransfertService;
use Illuminate\Http\Request;

class TransfereController extends Controller
{
    public function __construct(private TransfertService $transfertService){}

            /**
     * @OA\Get(
     *     path="/api/transfert",
     *     summary="liste des transferts",
     *     description="Liste des transfert.",
     *     operationId="listTousLesTransferts",
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
    $transfert = Transfere::with('dossierMedical.patient', 'fromService','toService')
    ->orderBy('id', 'DESC')
    ->get();
    return response()->json($transfert);
    }
    /**
 * @OA\Post(
 *      path="/api/patients/addTransfert",
 *      operationId="crateTransfertPatient",
 *      tags={"dossier_medical & Consultation"},
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
