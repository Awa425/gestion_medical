<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::resource('personnels', PersonnelController::class);
Route::get('users', [UserController::class, 'index']);


Route::middleware('auth:sanctum')->group( function () {

    // Route::resource('users', UserController::class);
});

