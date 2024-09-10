<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Qualification",
 *     type="object",
 *     title="Qualification",
 *     description="Schéma pour la qualification d'un personnel",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la qualification",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom_qualification",
 *         type="string",
 *         description="Nom de la qualification",
 *         example="Chirurgie"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description de la qualification",
 *         example="Chirurgie..."
 *     ),
 *     @OA\Property(
 *         property="date_obtention",
 *         type="date",
 *         description="date obtention",
 *         example="1985-10-15"
 *     )
 * )
 */
class QualificationSchema {}