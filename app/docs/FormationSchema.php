<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Formation",
 *     type="object",
 *     title="Formation",
 *     description="Schéma pour la formation d'un personnel",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la Formation",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom_formation",
 *         type="string",
 *         description="Nom de la formation",
 *         example="Formation chirugie"
 *     ),
 *     @OA\Property(
 *         property="organisme_formateur",
 *         type="string",
 *         description="La formation est organisée par ENDSS",
 *         example="Chirurgie..."
 *     ),
 *     @OA\Property(
 *         property="date_obtention",
 *         type="date",
 *         description="date obtention",
 *         example="1985-10-15"
 *     ),
 *    @OA\Property(
 *         property="date_debut",
 *         type="date",
 *         description="date de debut",
 *         example="1985-10-15"
 *     ),
 *    @OA\Property(
 *         property="statut",
 *         type="string",
 *         description="en cours ou terminé...",
 *         example="en cour"
 *     )
 * )
 */
class FormationSchema {}