<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\salle;
use App\Models\Sortie;
use App\Services\SortieService;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    public function __construct(private SortieService $sortieService){}

/**
 * @OA\Post(
 *      path="/api/patients/addSortie",
 *      operationId="crateSortiePatient",
 *      tags={"Admission & sortie & transfert"},
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
        'date_sortie' => 'required|date',
    ]);

    // Récupérer l'admission associée
    $admission = Admission::findOrFail($validatedData['admission_id']);

    // Vérifier si l'admission est encore en cours
    if ($admission->etat_admission === 'termine') {
        return response()->json([
            'message' => 'La sortie ne peut pas être enregistrée car le patient avait deja sortie.',
        ], 400);
    }

    // Créer la sortie
    $sortie = new Sortie();
    $sortie->admission_id = $validatedData['admission_id'];
    $sortie->motif_sortie = $validatedData['motif_sortie'];
    $sortie->etat_sortie = $validatedData['etat_sortie'];
    $sortie->date_sortie = now();
    $sortie->save();

    // Mettre à jour l'état de l'admission
    $admission->etat_admission = 'termine';
    $admission->save();

    // Récupérer la salle associée à l'admission
    $salle = salle::find($admission->salle_id);

    if ($salle) {
        // Augmenter la capacité de la salle
        $salle->lits_restants += 1;
        $salle->save();
    }

    return response()->json([
        'message' => 'Sortie enregistrée avec succès.',
        'sortie' => $sortie,
    ], 201);
}

}
