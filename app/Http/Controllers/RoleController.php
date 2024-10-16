<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/roles",
 *     summary="liste des Roles",
 *     description="Liste des roles.",
 *     operationId="listRoles",
 *     tags={"roles"},
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
        $role=Role::all();
        return response()->json($role);
    }
}
