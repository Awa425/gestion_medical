<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeCollection;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;

class TypeController extends BaseController
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return ResponseUtils::formatResponse(message: 'types retrieved successfully' , data: TypeCollection::collection(Type::all()));

        // return $this->sendResponse(TypeResource::collection($types), 'types retrieved successfully.');
    }
}
