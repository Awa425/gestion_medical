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
use App\Http\Controllers\SalleAttenteController;
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

// Personnel
Route::resource('roles', RoleController::class);
Route::resource('personnels', PersonnelController::class);
Route::resource('type-personnels', TypePersonnelController::class);
Route::get('medecin-list', [PersonnelController::class, 'medecinList']);
Route::get('medecins/service/{id}', [PersonnelController::class, 'medecinsByService']);
Route::resource('services', ServiceController::class);

// Patient et dossier
Route::resource('patients', PatientController::class);
Route::put('dossier/{id}', [DossierMedicalController::class, 'updateDossier']);
Route::get('patients-dossiers', [PatientController::class, 'getPatientWithMedical']);
Route::put('patients/salle_attentes/{id}', [PatientController::class, 'updateWaitingRoom']);
Route::post('salleAttente', [PatientController::class, 'storeWaitingRoom']);
Route::get('patients', [PatientController::class, 'listPatients']);
Route::get('patients/enAttente/services/{service_id}', [PatientController::class, 'listSalleAttenteByService']);
Route::get('salle-attente/service/{id}', [SalleAttenteController::class, 'salleAttenteByService']);
Route::get('listSalleAttente', [SalleAttenteController::class, 'listSalleAttente']);

Route::get('patient/enAttente', [SalleAttenteController::class, 'listPatientByEtatEnAttente']);
Route::get('detail-complet/patient/{id}', [PatientController::class, 'detailCompletPatient']);
Route::post('patients/create-consultation',[ConsultationController::class,'consulterPatient']);
Route::put('patients/consultation/{id}/update',[ConsultationController::class,'updateConsultation']);

// Admission sortie et transfere
Route::post('patients/addAdmission',[AdmissionController::class, 'store']);
Route::post('admissions/en-cours',[AdmissionController::class, 'getAdmissionEnCours']);
Route::post('patients/addSortie',[SortieController::class, 'store']);
Route::post('patients/addTransfert',[TransfereController::class, 'store']);
Route::resource('consultations', ConsultationController::class);
Route::resource('admissions', AdmissionController::class);

// Rendez-vous
Route::resource('rendezVous',RendezVousController::class);
Route::put('annuler/rendezVous/{id}',[RendezVousController::class, 'annuler']);



// Acces private
Route::middleware('auth:sanctum')->group( function () {
    Route::post('password/change', [AuthController::class, 'changePassword']);

});


