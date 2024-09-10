<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Http\Resources\PersonnelResource;
use App\Models\Certification;
use App\Models\Formation;
use App\Models\Personnel;
use App\Models\Qualification;
use App\Services\PersonnelService;
use App\Utils\FormatData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Gestion du Personnel",
 *      description="Documentation API pour la gestion du personnel",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * ),
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Serveur API"
 * ),
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
class PersonnelController extends BaseController
{
    public function __construct(protected PersonnelService $personnelService){}

    public function index()
    {
        $personnels = Personnel::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        $personnels->load('type','user','qualifications', 'formations', 'certifications');

        return FormatData::formatResponse(message: 'Liste du personnels', data: $personnels);
    }


/**
 * @OA\Post(
 *      path="/api/personnels",
 *      operationId="store",
 *      tags={"personnels"},
 *      summary="Créer un nouveau membre du personnel",
 *      description="Enregistre un nouveau membre du personnel dans la base de données.",
 *      security={{"bearerAuth":{}}},  
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Personnel")
 *      ),

 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Personnel")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'prenom' => 'required',
            'telephone' => 'nullable',
            'datte_naissance' => 'nullable',
            'lieu_naissance' => 'nullable',
            'adresse' => 'nullable',
            'matricule' => 'nullable',
            'CNI' => 'nullable',
            'datte_embauche' => 'date',
            'type_personnel_id' => 'exists:type_personnels,id',
        ]);

        if($validator->fails()){
            return response()->json(['Error' => 'Erreur de validation'], 404);      
        }

        $personnel = $this->personnelService->createPersonnelWithDetails([
            'personnel' => $request->only([
                'name', 
                'prenom', 
                'datte_naissance', 
                'lieu_naissance', 
                'adresse', 
                'telephone', 
                'email', 
                'CNI', 
                'matricule', 
                'date_embauche',
                'type_personnel_id'
            ]), 
            'user' => $request->get('user'),
            'qualifications' => $request->get('qualifications'),
            'formations' => $request->get('formations'),
            'certifications' => $request->get('certifications'),
        ]);  

        return response()->json([
            'message' => 'Personnel créé avec succès.',
            'personnel' => $personnel,
        ], 201);
    }

    public function update(Request $request, Personnel $personnel)
    {
       // Utiliser le service pour gérer la logique de mise à jour
       $updatedPersonnel = $this->personnelService->updatePersonnelWithDetails($personnel, [
        'personnel' => $request->only([
            'name', 
            'prenom', 
            'datte_naissance', 
            'lieu_naissance', 
            'adresse', 
            'telephone', 
            'email', 
            'CNI', 
            'matricule', 
            'date_embauche',
            'type_personnel_id'
        ]),
        'user' => $request->get('user'),
        'qualifications' => $request->get('qualifications'),
        'formations' => $request->get('formations'),
        'certifications' => $request->get('certifications'),
    ]);

    return response()->json([
        'message' => 'Personnel mis à jour avec succès.',
        'personnel' => $updatedPersonnel,
    ], 200);
    }

    public function show(string $id)
    {
         $personnel = Personnel::find($id);
  
        if (is_null($personnel)) {
            return $this->sendError('Personnel not found.');
        }

        return $personnel->load('user','qualifications', 'formations', 'certifications');

    }

    public function destroy(Request $request, Personnel $personnel)
    {
        $personnel->update([
            'isActive' => !$personnel->isActive,
        ]);
        return response()->json(['message' => 'Désactiver avec succès'], 200);
    }
}
