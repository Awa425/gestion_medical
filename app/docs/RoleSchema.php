<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Role",
 *     description="Role de la personne",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID du role",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Nom du role",
 *         example="Medecin"
 *     )
 * )
 */
class RoleSchema {}