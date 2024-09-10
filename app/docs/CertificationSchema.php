<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Certification",
 *     type="object",
 *     title="Certification",
 *     description="Schéma pour la Certification d'un personnel",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la Certification",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom_certification",
 *         type="string",
 *         description="Nom de la certification",
 *         example="Certification A"
 *     ),
 *     @OA\Property(
 *         property="organisme_delivrant",
 *         type="date",
 *         description="Date de delivrance de la certification",
 *         example="1985-10-15"
 *     ),
 *     @OA\Property(
 *         property="date_obtention",
 *         type="date",
 *         description="date obtention",
 *         example="1985-10-15"
 *     ),
 *     @OA\Property(
 *         property="date_expiration",
 *         type="date",
 *         description="date d'expiration",
 *         example="1985-10-15"
 *     )
 * )
 */
class CertificationSchema {}