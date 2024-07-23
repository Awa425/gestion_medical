<?php

namespace App\Http\Controllers;

use App\Http\Resources\salleResource;
use App\Models\salle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalleController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $salles = salle::all();
    
        return $this->sendResponse(salleResource::collection($salles), 'salles retrieved successfully.');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'libelle' => 'required',
            'nombre_lits' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $salle = salle::create($input);
   
        return $this->sendResponse(new SalleResource($salle), 'salle created successfully.');
    }

       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $salle = Salle::find($id);
  
        if (is_null($salle)) {
            return $this->sendError('Salle not found.');
        }
   
        return $this->sendResponse(new SalleResource($salle), 'SAlle retrieved successfully.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, salle $salle): JsonResponse
    {
        $input = $request->all();
        if($input['libelle']){
            $salle->libelle = $input['libelle'];
        }
        if($input['nombre_lits']){
            $salle->nombre_lits  = $input['nombre_lits'];
        }

        $salle->save();
   
        return $this->sendResponse(new SalleResource($salle), 'Salle updated successfully.');
    }
   
}
