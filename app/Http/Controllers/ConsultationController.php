<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends BaseController
{

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultation = Consultation::all();
    
        return $this->sendResponse(ConsultationResource::collection($consultation), 'Consultation retrieved successfully.');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'libelle' => 'required',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $consultation = Consultation::create($input);
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation crée avec succes.');
    }

        /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $consultation = Consultation::find($id);
  
        if (is_null($consultation)) {
            return $this->sendError('Specialite not found.');
        }
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation retrieved successfully.');
    }

        /**
     * Update the specified resource in storage.
     */
    public function update(ConsultationRequest $request, Consultation $consultation)
    {
        $consultation->update($request->validated());

        $consultation->save();
   
        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation updated successfully.');
    }

}
