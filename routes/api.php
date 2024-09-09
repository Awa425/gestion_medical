<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\TypePersonnelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);


Route::resource('personnels', PersonnelController::class);
Route::resource('patients', PatientController::class);
Route::resource('dossierMedical', DossierMedicalController::class);
Route::get('users', [UserController::class, 'index']);
Route::get('types', [TypePersonnelController::class, 'index']);
Route::get('categories', [CategorieController::class, 'index']);


Route::middleware('auth:sanctum')->group( function () {
    Route::post('password/change', [AuthController::class, 'changePassword']);
    // Route::resource('users', UserController::class);
});

