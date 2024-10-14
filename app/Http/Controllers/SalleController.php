<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateSalleRequest;
use App\Http\Resources\salleResource;
use App\Models\salle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalleController extends BaseController
{

    // public function index(): JsonResponse
    // {
    //     $salles = Salle::all();
    
    //     return $this->sendResponse(result: salleResource::collection($salles), 'salles retrieved successfully.');
    // }
    

    // public function store(Request $request): JsonResponse
    // {
    //     $input = $request->all();
   
    //     $validator = Validator::make($input, [
    //         'libelle' => 'required',
    //         'nombre_lits' => 'required'
    //     ]);
   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
   
    //     $salle = salle::create($input);
   
    //     return $this->sendResponse(new SalleResource($salle), 'salle created successfully.');
    // }

 
    // public function show($id): JsonResponse
    // {
    //     $salle = Salle::find($id);
  
    //     if (is_null($salle)) {
    //         return $this->sendError('Salle not found.');
    //     }
   
    //     return $this->sendResponse(new SalleResource($salle), 'SAlle retrieved successfully.');
    // }


    // public function update(updateSalleRequest $request, salle $salle): JsonResponse
    // {
    //     $salle->update($request->validated());

    //     $salle->save();
   
    //     return $this->sendResponse(new SalleResource($salle), 'Salle updated successfully.');
    // }
   
}
