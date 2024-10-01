<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Service",
 *     type="object",
 *     title="Services",
 *     description="Les service de l'hopital",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID du service",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Nom du service",
 *         example="Cardiologie"
 *     )
 * )
 */
class ServiceSchema {}