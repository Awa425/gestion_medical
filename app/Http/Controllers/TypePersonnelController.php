<?php

namespace App\Http\Controllers;

use App\Models\TypePersonnel;
use Illuminate\Http\Request;
use App\Utils\FormatData;

class TypePersonnelController extends BaseController
{
/**
 * @OA\Get(
 *     path="/api/type-personnels",
 *     summary="liste personnel",
 *     description="Liste des types de personnel.",
 *     operationId="listTypePersonnel",
 *     tags={"personnels"},
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
        $types = TypePersonnel::all();
        return FormatData::formatResponse(message: 'Liste des types de personnels', data: $types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
