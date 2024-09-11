<?php

namespace App\Docs;

/**
 * @OA\OpenApi(
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="Serveur API"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="sanctumAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *             description="Utilisez un token Bearer généré par Sanctum pour l'authentification."
 *         )
 *     )
 * )
 */
class OpenApiDocumentation{}
