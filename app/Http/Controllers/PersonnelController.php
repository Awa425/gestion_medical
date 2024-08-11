<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\UpdatePersonnelRequest;
use App\Http\Resources\PersonnelResource;
use App\Models\Personnel;
use App\Utils\FormatData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonnelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnels = Personnel::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        return FormatData::formatResponse( data: PersonnelResource::collection($personnels),);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'prenom' => 'required',
            'telephone' => 'nullable',
            'date_naissance' => 'nullable',
            'lieu_naissance' => 'nullable',
            'adresse' => 'nullable',
            'date_embauche' => 'date',
            'type_personnel_id' => 'exists:type_personnels,id',
        ]);
        if($validator->fails()){
            return $request->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        
        $personnel = Personnel::create($input);

        return $this->sendResponse(new PersonnelResource($personnel), 'Personnel register successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
