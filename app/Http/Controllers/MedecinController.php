<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedecinStoreRequest;
use App\Http\Resources\MedecinCollection;
use App\Http\Resources\MedecinResource;
use App\Models\Medecin;
use App\Models\Role;
use App\Models\User;
use App\Providers\RoleServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MedecinController extends BaseController
{
    public function index(Request $request)
    {
        return new MedecinCollection(Medecin::where('is_active','=',1)
            ->filter()
            ->paginate(request()->get('perpage', env('DEFAULT_PAGINATION')), ['*'], 'page')
           );

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'prenom' => 'required',
            'telephone' => 'nullable',
            'adresse' => 'nullable',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role_id' => 'exists:types,id',
        ]);

        if($validator->fails()){
            return $request->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        // Get the currently authenticated user's ID
        $input['user_id'] = Auth::id();
        $user = $input;
        $user['role_id'] = Role::where('libelle', RoleServiceProvider::MEDECIN)->pluck('id')->first();
        
        $medecin = Medecin::create($input);
        if ($medecin) {
            $user = User::create($user); 
        
        
        $success['token'] =  $medecin->createToken('MyApp')->plainTextToken;
        $success['data'] =  $medecin;

        return $this->sendResponse($success, 'Medecin register successfully.');
        }
    }

    public function searchAppByTel($param){
        $med=Medecin::where(['telephone'=>$param])->first();
        if ($med) {
            return new MedecinResource($med);
        }
        return response([
            "message" => "Medecin introuvable"
        ]);
    }

    
}
