<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Utils\FormatData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $users = User::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();

        return FormatData::formatResponse(message: 'Liste des utilisateurs', data: UserResource::collection($users));

    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    /**
     * Store a new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update([
            'isActive' => !$user->isActive,
        ]);
        return response()->json(['message' => 'Désactiver avec succès'], 200);
    }
}
