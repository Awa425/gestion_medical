<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Utils\FormatData;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FormatData::formatResponse( data: UserResource::collection(User::all()),);

    }

    /**
     * Store a new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'personnel_id' => 'exists:personnels,id',
        ]);
        if($validator->fails()){
            return $request->sendError('Validation Error.', $validator->errors());       
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);

        // $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        // $success['data'] =  $user;

        // return $this->sendResponse($success, 'User register successfully.');
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
    public function destroy(string $id)
    {
        //
    }
}
