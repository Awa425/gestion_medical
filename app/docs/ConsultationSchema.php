<?php
namespace App\Docs;




// ***************************************Schema Consultation **************************************
/**
 * @OA\Schema(
 *     schema="Consultation",
 *     type="object",
 *     title="Consultation",
 *     description="Schéma représentant un Consultation",
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Nom de la consultation",
 *         example="Ophtalmologie"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         description="Note prise lors de la consultation",
 *         example="mettez les notes ici"
 *     ),
 *    @OA\Property(
 *         property="dossierMedical",
 *         type="object",
 *         ref="#/components/schemas/DossierMedical", 
 *         description="Votre dossier medical"
 *     ),
 *     @OA\Property(
 *         property="medecin_id",
 *         type="integer",
 *         description="Medecin associée",
 *         example="59" 
 *     ),
 *      @OA\Property(
 *         property="patient_id",
 *         type="integer",
 *         description="Patient consulté",
 *         example="1" 
 *     ),
 *      @OA\Property(
 *         property="service_id",
 *         type="integer",
 *         description="Service a aller",
 *         example="1" 
 *     )
 * )
 */
class ConsultationSchema {}