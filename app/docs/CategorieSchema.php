<?php
namespace App\Docs;
/**
 * @OA\Schema(
 *     schema="Categorie",
 *     type="object",
 *     title="Categorie",
 *     description="Schéma pour une catégorie",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la catégorie",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="libelle",
 *         type="string",
 *         description="Nom de la catégorie",
 *         example="Personnel Administratif"
 *     )
 * )
 */
class CategorieSchema {}