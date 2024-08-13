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
    // protected $personnelService;

    public function __construct(protected PersonnelService $personnelService)
    {
        // $this->personnelService = $personnelService;
    }

    public function index()
    {
        $personnels = Personnel::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        return FormatData::formatResponse( data: PersonnelResource::collection($personnels),);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $personnel = Personnel::find($id);
  
        if (is_null($personnel)) {
            return $this->sendError('Personnel not found.');
        }
   
        return $this->sendResponse(new PersonnelResource($personnel), 'Personnel retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonnelRequest $request, Personnel $personnel)
    {
        $personnel->update($request->validated());
        
        $personnel->save();

        return $this->sendResponse(new PersonnelResource($personnel), 'personnel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Personnel $personnel)
    {
        $personnel->update([
            'isActive' => !$personnel->isActive,
        ]);

        return response()->json(['message' => 'Désactiver avec succès'], 200);
    }
}
