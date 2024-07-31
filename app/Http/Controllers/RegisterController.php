<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class RegisterController extends BaseController
{
        /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'prenom' => 'required',
            'telephone' => 'nullable',
            'adresse' => 'nullable',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'type_id' => 'exists:types,id',
        ]);
        
        if($validator->fails()){
            return $request->sendError('Validation Error.', $validator->errors());       
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['data'] =  $user;

        return $this->sendResponse($success, 'User register successfully.');
    }

     /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
             /** @var \App\Models\User $user **/
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['data'] =  $user;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
