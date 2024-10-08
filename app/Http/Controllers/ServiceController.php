<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServiceRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Utils\FormatData;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
   /**
 * @OA\Get(
 *     path="/api/services",
 *     summary="liste services",
 *     description="Liste de tous les services.",
 *     operationId="listservices",
 *     tags={"Services"},
 *     security={{"sanctumAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Données récupérées avec succès.",
 *         @OA\JsonContent(type="object", @OA\Property(property="data", type="string"))
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
public function index()
{   
    $service = Service::all();
    return FormatData::formatResponse(message: 'Liste des patients', data: $service);
}


  

 
}
