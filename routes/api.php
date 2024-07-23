<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('salles', SalleController::class);
});

