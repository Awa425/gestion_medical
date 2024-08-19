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

class PersonnelController extends BaseController
{
    public function __construct(protected PersonnelService $personnelService){}

    public function index()
    {
        $personnels = Personnel::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        $personnels->load('type','qualifications', 'formations', 'certifications');

        return FormatData::formatResponse(message: 'Liste du personnels', data: $personnels);
    }

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
            return $request->sendError('Validation Error.', $validator->errors());       
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

        return $personnel->load('type','qualifications', 'formations', 'certifications');

    }

    public function destroy(Request $request, Personnel $personnel)
    {
        $personnel->update([
            'isActive' => !$personnel->isActive,
        ]);
        return response()->json(['message' => 'Désactiver avec succès'], 200);
    }
}
