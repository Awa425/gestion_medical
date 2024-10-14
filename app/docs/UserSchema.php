<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="Schéma pour un utilisateur",
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
 *         type="integer", 
 *         description="Role associée",
 *         example=1
 *     )
 * )
 */
class UserSchema {}