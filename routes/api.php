<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('salles', SalleController::class);
    Route::resource('users', UserController::class);
    Route::resource('profiles', ProfileController::class);
    Route::resource('types', TypeController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('specialites', SpecialiteController::class);
    Route::resource('consultations', ConsultationController::class);
});

