<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="TypePersonnel",
 *     type="object",
 *     title="Type personnel",
 *     description="Type du Personnel(Medecin, caissier...)",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID du type",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Nom du Type de Personnel",
 *         example="Medecin"
 *     ),
 *      @OA\Property(
 *         property="categorie_id",
 *         ref="#/components/schemas/Categorie",
 *         description="Categorie associée"
 *     ),
 * )
 */
class TypePersonnelSchema {}