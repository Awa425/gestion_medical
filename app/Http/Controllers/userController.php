<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseUtils::formatResponse( data: UserResource::collection(User::all()),);

    }

    /**
     * Store a new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        // $user = User::create(array_merge(
        //     $request->validated(),
        //     ['password' => bcrypt('Passer')]
        // ));
        // $user->assignRole([$request->type_id]);

        // return ResponseUtils::formatResponse(message: 'Utilisateur inscrit avec succès', status: 201, data: new UserResource($user));
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
