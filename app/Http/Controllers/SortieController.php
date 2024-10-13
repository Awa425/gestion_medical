<?php

namespace App\Http\Controllers;

use App\Services\SortieService;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    public function __construct(private SortieService $sortieService){}

/**
 * @OA\Post(
 *      path="/api/patients/addSortie",
 *      operationId="crateSortiePatient",
 *      tags={"dossier_medical"},
 *      summary="Ajout sortie patient",
 *      description="Sortie patient.",
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Sortie")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Sortie")
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
            'admission_id' => 'required|exists:admissions,id',
            'motif_sortie' => 'required|string',
            'etat_sortie' => 'nullable|string',
        ]);

        $sortie = $this->sortieService->creerSortie($validatedData);

        return response()->json([
            'message'=>'Success',
            'sortie' => $sortie,
        ], 201);
    }
}
