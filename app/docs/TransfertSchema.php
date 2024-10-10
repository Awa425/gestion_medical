<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="transfert",
 *     type="object",
 *     title="Transfere du patient",
 *     description="Schéma pour transferer'un patient",
 *     @OA\Property(
 *         property="motif_transfert",
 *         type="string",
 *         description="Motif de transfert",
 *         example="Le patient a guerie"
 *     ),
*     @OA\Property(
 *         property="date_transfert",
 *         type="string",
 *         description="Date de transfert",
 *         example="gueri"
 *     ),
 *     @OA\Property(
 *         property="dossierMedical_id",
 *         type="integer",
 *         description="Dossier medical du patient",
 *         example="4"
 *     ),
 *     @OA\Property(
 *         property="from_service_id",
 *         type="integer",
 *         description="Service de depart",
 *         example="4"
 *     ),
 *     @OA\Property(
 *         property="to_service_id",
 *         type="integer",
 *         description="Service a aller",
 *         example="4"
 *     ),
 * )
 */
class TransfertSchema {}