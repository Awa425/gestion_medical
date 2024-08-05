<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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
        $users = User::where('isActive', 1)
        ->orderBy('id', 'DESC')
        ->get();
        return ResponseUtils::formatResponse( data: UserResource::collection($users),);

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
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        $user->save();

        return ResponseUtils::formatResponse( data: UserResource::collection($user),);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
