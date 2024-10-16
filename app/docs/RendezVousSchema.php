<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="RendezVous",
 *     type="object",
 *     title="Rendez-vous",
 *     description="Gestion des Rendez-vous",
 *     @OA\Property(
 *         property="patient_id",
 *         type="integer",
 *         description="Id du patient",
 *         example=1
 *     ),
*     @OA\Property(
 *         property="medecin_id",
 *         type="integer",
 *         description="Id du medecin",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="service_id",
 *         type="integer",
 *         description="Id du service",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="date_heure",
 *         type="date",
 *         description="date et heure du rendez-vous",
 *         example="2024-10-15 08:00:00"
 *     ),
 *     @OA\Property(
 *         property="statut",
 *         type="string",
 *         description="statut programmé, annulé ou terminé",
 *         example="programmé"
 *     ),
 *     @OA\Property(
 *         property="motif",
 *         type="string",
 *         description="Motif du Rendez-vous",
 *         example="Donner le motif"
 *     )
 * )
 */
class RendezVousSchema {}