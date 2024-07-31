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
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salles = Salle::all();
    
        return $this->sendResponse(salleResource::collection($salles), 'salles retrieved successfully.');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'libelle' => 'required',
            'nombre_lits' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $salle = Salle::create($input);
   
        return $this->sendResponse(new SalleResource($salle), 'salle created successfully.');
    }

       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salle = Salle::find($id);
  
        if (is_null($salle)) {
            return $this->sendError('Salle not found.');
        }
   
        return $this->sendResponse(new SalleResource($salle), 'Salle retrieved successfully.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateSalleRequest $request, salle $salle)
    {
        $salle->update($request->validated());

        $salle->save();
   
        return $this->sendResponse(new SalleResource($salle), 'Salle updated successfully.');
    }
   
}
