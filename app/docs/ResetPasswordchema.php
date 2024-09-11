<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="ResetPassword",
 *     type="object",
 *     title="Reset Password",
 *     description="Changer votre mot de passe ",
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Reset Password",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         description="Confirm Password",
 *         example="password123"
 *     )
 * )
 */
class ResetPasswordchema {}