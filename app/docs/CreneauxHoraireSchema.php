<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Disponibilite",
 *     title="Disponibilite",
 *     description="Modèle de disponibilité d'un médecin",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="medecin_id", type="integer", example=1),
 *     @OA\Property(property="date", type="string", format="date", example="2025-03-11"),
 *     @OA\Property(property="heure", type="string", format="time", example="09:00"),
 *     @OA\Property(property="est_disponible", type="boolean", example=true)
 * )
 */
class CreneauxHoraireSchema {}