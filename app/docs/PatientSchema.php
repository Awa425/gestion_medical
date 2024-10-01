<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     title="Patients",
 *     description="Patients",
 *     required={"nom", "prenom", "date_naissance"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID du patient",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nom",
 *         type="string",
 *         description="Nom du patient",
 *         example="Sow"
 *     ),
 *     @OA\Property(
 *         property="prenom",
 *         type="string",
 *         description="prenom du patient",
 *         example="Abdou"
 *     ),
 *     @OA\Property(
 *         property="date_naissance",
 *         type="date",
 *         description="date naissance du patient",
 *         example="1985-10-15"
 *     ),
 *     @OA\Property(
 *         property="telephone",
 *         type="string",
 *         description="Numero Telephone du patient",
 *         example="+221777743779"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email de contact du patient",
 *         example="patient1@gmail.com"
 *     ),
 *     @OA\Property(
 *         property="sexe",
 *         type="string",
 *         description="Masculin ou Feminin",
 *         example="M"
 *     ),
 *     @OA\Property(
 *         property="groupe_sanguin",
 *         type="string",
 *         description="Groupe sanguin du patient",
 *         example="A+"
 *     ),
 *     @OA\Property(
 *         property="matricule",
 *         type="string",
 *         description="Matricule du patient",
 *         example="AZER12345"
 *     ),
 *     @OA\Property(
 *         property="dossierMedical",
 *         ref="#/components/schemas/DossierMedical",
 *         description="Dossier medical associée a la patient",
 *     ) 
 * )
 */
class PatientSchema {}