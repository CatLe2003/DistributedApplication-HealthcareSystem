<?php

use App\Http\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalVisitController;

//patient
Route::post('/register-patient', [PatientController::class, 'register'])
    ->name('patient.register');

Route::get('/get-patient/{id}', [PatientController::class, 'show'])
->name('patient.show');

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