<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="DossierMedical",
 *     type="object",
 *     title="Dossier Medical",
 *     description="Dossier medical d'une patient",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID du dossier",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="numero_dossier",
 *         type="string",
 *         description="Numero du dossier",
 *         example="ABC123"
 *     ),
 *     @OA\Property(
 *         property="antecedents",
 *         type="string",
 *         description="Les antecedents du patients",
 *         example="Antécédents de diabète"
 *     ),
 *     @OA\Property(
 *         property="diagnostics",
 *         type="string",
 *         description="Les diagnostics du patients",
 *         example="hypertension"
 *     ),
 *     @OA\Property(
 *         property="traitements",
 *         type="string",
 *         description="Les traitements du patients",
 *         example="Ortho"
 *     ),
 *     @OA\Property(
 *         property="prescriptions",
 *         type="string",
 *         description="Les prescriptions du patients",
 *         example="Prescrit 5 mg de Lisinopril par jour"
 *     ) 
 * )
 */
class DossierMedicalSchema {}