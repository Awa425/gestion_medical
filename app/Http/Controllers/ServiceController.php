<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServiceRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends BaseController
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return ResponseUtils::formatResponse(message: 'Services retrieved successfully' , data: ServiceResource::collection($services));
    }

    /**
     * Create newresource.
     */
    public function store(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input, [
            'libelle' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $Service = Service::create($input);
        return $this->sendResponse(new ServiceResource($Service), 'Service created successfully.');
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
  
        if (is_null($service)) {
            return $this->sendError('Service not found.');
        }
   
        return $this->sendResponse(new ServiceResource($service), 'Service retrieved successfully.');
    }

    
         /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        $service->save();
   
        return $this->sendResponse(new ServiceResource($service), 'service updated successfully.');
    }
}
