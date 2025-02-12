<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Salle",
 *     type="object",
 *     title="Salle",
 *     description="Gestion des salles",
 *     @OA\Property(
 *         property="service_id",
 *         type="integer",
 *         description="Service associée",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="nom",
 *         type="string",
 *         description="Nom de la salle",
 *         example="A1"
 *     ),
 *     @OA\Property(
 *         property="capacite",
 *         type="string",
 *         description="Nombre de place",
 *         example="5"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type de salle",
 *         example="chambre"
 *     ),
 *     @OA\Property(
 *         property="disponible",
 *         type="boolean",
 *         description="Disponibilite de la salle",
 *         example=1
 *     )
 * )
 */
class SalleSchema {}