<?php

use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::resource('personnels', PersonnelController::class);


Route::middleware('auth:sanctum')->group( function () {

    // Route::resource('salles', SalleController::class);
    // Route::resource('users', UserController::class);
});

