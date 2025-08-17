<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\MedicalVisitController;
use App\Http\Controllers\PrescriptionController;

//patient
Route::post('/register-patient', [PatientController::class, 'register'])
    ->name('patient.register');

Route::get('/get-patient/{id}', [PatientController::class, 'show'])
->name('patient.show');

Route::put('/update-patient/{id}', [PatientController::class, 'update'])
->name('patient.update');

Route::delete('/delete-patient/{id}', [PatientController::class, 'delete'])
->name('patient.delete');

//medicalvisit
Route::post('/create-medicalvisit', [MedicalVisitController::class, 'create'])
    ->name('medicalvisit.create');

Route::get('/get-medicalvisit/{id}', [MedicalVisitController::class, 'show'])
    ->name('medicalvisit.show');

//prescription
Route::post('/create-prescription', [PrescriptionController::class, 'create'])
    ->name('prescription.create');

Route::get('/get-prescription/{id}', [PrescriptionController::class, 'show'])
    ->name('prescription.show');

//order
Route::post('/create-order', [OrderController::class, 'create'])
    ->name('order.create');

Route::get('/get-order/{id}', [OrderController::class, 'show'])
    ->name('order.show');

//followup
Route::post('/create-followup', [FollowUpController::class, 'create'])
    ->name('followup.create');

Route::get('/get-followup/{id}', [FollowUpController::class, 'show'])
    ->name('followup.show');