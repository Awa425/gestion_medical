<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Auth",
 *     type="object",
 *     title="Login",
 *     description="Schéma pour s'authentifier",
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Login",
 *         example="admin@gmail.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Mot de passe",
 *         example="password"
 *     )
 * )
 */
class AuthSchema {}