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
 *         property="email",
 *         type="string",
 *         description="Adresse email du personnel",
 *         example="diop.awa@example.com"
 *     ),
 *     @OA\Property(
 *         property="telephone",
 *         type="string",
 *         description="Numéro de téléphone",
 *         example="+221772345678"
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
 *         property="matricule",
 *         type="string",
 *         format="string",
 *         description="Matricule du personnel",
 *         example="VGFR7548765"
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
 *         ref="#/components/schemas/TypePersonnel",
 *         description="Type personnel associée"
 *     ),
*    @OA\Property(
 *         property="qualifications",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Qualification"), 
 *         description="Liste des qualifications du personnel"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User",
 *         description="User personnel associée"
 *     ),
 * )
 */
class PersonnelSchema {}


