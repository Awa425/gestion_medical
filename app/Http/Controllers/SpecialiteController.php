<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSpecialiteRequest;
use App\Http\Resources\SpecialiteResource;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialiteController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialite = Specialite::all();
    
        return $this->sendResponse(SpecialiteResource::collection($specialite), 'specialite retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'nom' => 'required',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $specialite = Specialite::create($input);
   
        return $this->sendResponse(new SpecialiteResource($specialite), 'specialite crée avec succes.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specialite = Specialite::find($id);
  
        if (is_null($specialite)) {
            return $this->sendError('Specialite not found.');
        }
   
        return $this->sendResponse(new SpecialiteResource($specialite), 'Specialite retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialiteRequest $request, Specialite $specialite)
    {
        $specialite->update($request->validated());

        $specialite->save();
   
        return $this->sendResponse(new SpecialiteResource($specialite), 'specialite updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
