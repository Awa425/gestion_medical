<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Admission",
 *     type="object",
 *     title="Admission",
 *     description="Schéma pour une Admission",
 *     @OA\Property(
 *         property="motif_admission",
 *         type="string",
 *         description="Motif de l'admission",
 *         example="Maladie contagieuse"
 *     ),
 *     @OA\Property(
 *         property="dossierMedical_id",
 *         type="integer",
 *         description="Dossier medical du patient en question",
 *         example="4"
 *     ),
 *     @OA\Property(
 *         property="service_id",
 *         type="integer",
 *         description="Service",
 *         example="2"
 *     )
 * )
 */
class AdmissionSchema {}