<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeCollection;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends BaseController
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return ResponseUtils::formatResponse(message: 'types retrieved successfully' , data: TypeResource::collection($types));
    }

    public function store(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input, [
            'libelle' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $type = Type::create($input);
        return $this->sendResponse(new TypeResource($type), 'Type created successfully.');

    }
}
