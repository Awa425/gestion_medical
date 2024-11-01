<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="DossierMedical",
 *     type="object",
 *     description="Dossier médical du patient",
 *     @OA\Property(
 *         property="antecedents",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example="Diabète"
 *         ),
 *         description="Liste des antécédents du patient"
 *     ),
 *     @OA\Property(
 *         property="diagnostics",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example="Appendicite"
 *         ),
 *         description="Liste des diagnostics du patient"
 *     ),
 *     @OA\Property(
 *         property="traitements",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example="Antibiotiques"
 *         ),
 *         description="Liste des traitements du patient"
 *     ),
 *     @OA\Property(
 *         property="prescriptions",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example="Paracétamol 500mg"
 *         ),
 *         description="Liste des prescriptions médicales"
 *     )
 * )
 */
class DossierMedicalSchema {}




