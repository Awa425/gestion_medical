<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="Schéma pour un utilisateur",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de l'utilisateur",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email de l'utilisateur",
 *         example="user1@hopital.com"
 *     ),
  *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Mot de passe de l'utilisateur",
 *         example="password"
 *     ),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Role"), 
 *         description="Role associée"
 *     )
 * )
 */
class UserSchema {}