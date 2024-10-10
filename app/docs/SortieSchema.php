<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Sortie",
 *     type="object",
 *     title="Sortie de l'admission",
 *     description="Schéma pour une Sortie d'un patient",
 *     @OA\Property(
 *         property="motif_sortie",
 *         type="string",
 *         description="Motif du Sortie",
 *         example="Le patient a guerie"
 *     ),
*     @OA\Property(
 *         property="etat_sortie",
 *         type="string",
 *         description="Etat du Sortie",
 *         example="gueri"
 *     ),
 *     @OA\Property(
 *         property="admission_id",
 *         type="integer",
 *         description="L'admission correspondant a cette sortie",
 *         example="4"
 *     ),
 * )
 */
class SortieSchema {}