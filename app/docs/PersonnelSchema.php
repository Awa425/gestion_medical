<?php
namespace App\Docs;




// ***************************************Schema Personnel **************************************

/**
 * @OA\Schema(
 *     schema="Personnel",
 *     type="object",
 *     title="Personnel",
 *     description="Schéma représentant un membre du personnel",
 *     required={"name", "prenom"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom du personnel",
 *         example="Diop"
 *     ),
 *     @OA\Property(
 *         property="prenom",
 *         type="string",
 *         description="Prénom du personnel",
 *         example="Awa"
 *     ),
 *     @OA\Property(
 *         property="telephone",
 *         type="string",
 *         description="Numéro de téléphone",
 *         example="+221772345678"
 *     ),
 *     @OA\Property(
 *         property="adresse",
 *         type="string",
 *         description="Adresse",
 *         example="Dakar"
 *     ),
 *     @OA\Property(
 *         property="datte_naissance",
 *         type="string",
 *         format="date",
 *         description="Date de naissance",
 *         example="1985-10-15"
 *     ),
 *      @OA\Property(
 *         property="lieu_naissance",
 *         type="string",
 *         format="string",
 *         description="Lieu de naissance",
 *         example="1985-10-15"
 *     ),
 *      @OA\Property(
 *         property="CNI",
 *         type="string",
 *         format="string",
 *         description="Numero carte d'identité",
 *         example="154367548765"
 *     ),
 *     @OA\Property(
 *         property="date_embauche",
 *         type="date",
 *         format="date",
 *         description="Mdate d'embauche",
 *         example="1985-10-15"
 *     ),
 *      @OA\Property(
 *         property="type_personnel_id",
 *         type="integer", 
 *         description="Type personnel associée",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User",
 *         description="User personnel associée"
 *     ),
 *     @OA\Property(
 *         property="service_id",
 *         type="integer",
 *         description="Service affecté"
 *     )
 * )
 */
class PersonnelSchema {}


// ***************************************Schema Personnel **************************************





