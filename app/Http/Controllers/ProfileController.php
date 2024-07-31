<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Profile::all();
        return $this->sendResponse(ProfileResource::collection($profile), 'Profile retrieved successfully.');
    }

        /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileStoreRequest $request)
    {
        $profile = Profile::create($request->validated());
        return ResponseUtils::formatResponse(message: 'Profile crée avec succès', status: 201, data: $profile);
    }

        /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return ResponseUtils::formatResponse(data: $profile);
    }

        /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $profile->update($request->validated());
        return ResponseUtils::formatResponse(message: 'profile modifiée avec succès', status: 201, data: $profile);
    }
}
