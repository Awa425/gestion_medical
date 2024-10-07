<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ConsultationController;
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


Route::resource('dossierMedical', DossierMedicalController::class);
Route::get('users', [UserController::class, 'index']);
Route::get('types', [TypePersonnelController::class, 'index']);
Route::get('categories', [CategorieController::class, 'index']);
Route::post('consultations', [ConsultationController::class, 'store']);

Route::resource('personnels', PersonnelController::class);

Route::put('patients/{id}/dossier', [PatientController::class, 'createDossier']);
Route::post('salleAttente', [PatientController::class, 'storeWaitingRoom']);
Route::get('patients/salle-attente-list', [PatientController::class, 'listSalleAttente']);
Route::resource('patients', PatientController::class);
Route::get('patients', [PatientController::class, 'listPatients']);
Route::post('patients/create-consultation',[ConsultationController::class,'consulterPatient']);
Route::get('patients/enAttente/services/{service_id}', [PatientController::class, 'listSalleAttenteByService']);

// Acces private
Route::middleware('auth:sanctum')->group( function () {
    Route::post('password/change', [AuthController::class, 'changePassword']);

});


