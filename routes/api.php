<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SortieController;
use App\Http\Controllers\TransfereController;
use App\Http\Controllers\TypePersonnelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);


Route::resource('dossierMedical', DossierMedicalController::class);
Route::get('users', [UserController::class, 'index']);
Route::get('types', [TypePersonnelController::class, 'index']);
Route::get('categories', [CategorieController::class, 'index']);

Route::resource('roles', RoleController::class);

Route::resource('personnels', PersonnelController::class);
Route::resource('type-personnels', TypePersonnelController::class);
Route::get('medecin-list', [PersonnelController::class, 'medecinList']);


Route::post('salleAttente', [PatientController::class, 'storeWaitingRoom']);

// Route::put('patients/{id}/dossier', [PatientController::class, 'createDossier']);
Route::put('dossier/{id}', [DossierMedicalController::class, 'updateDossier']);
Route::get('patients-dossiers', [PatientController::class, 'getPatientWithMedical']);
Route::get('patients/salle-attente-list', [PatientController::class, 'listSalleAttente']);
Route::put('patients/salle_attentes/{id}', [PatientController::class, 'updateWaitingRoom']);
Route::resource('patients', PatientController::class);
Route::get('patients', [PatientController::class, 'listPatients']);
Route::post('patients/create-consultation/salle-attente/{id}',[ConsultationController::class,'consulterPatient']);
Route::put('patients/consultation/{id}/update',[ConsultationController::class,'updateConsultation']);

Route::resource('consultations', ConsultationController::class);
Route::get('patients/enAttente/services/{service_id}', [PatientController::class, 'listSalleAttenteByService']);
Route::post('patients/addAdmission',[AdmissionController::class, 'store']);
Route::post('patients/addSortie',[SortieController::class, 'store']);
Route::post('patients/addTransfert',[TransfereController::class, 'store']);

Route::resource('rendezVous',RendezVousController::class);
Route::put('annuler/rendezVous/{id}',[RendezVousController::class, 'annuler']);

Route::resource('services', ServiceController::class);

// Acces private
Route::middleware('auth:sanctum')->group( function () {
    Route::post('password/change', [AuthController::class, 'changePassword']);

});


