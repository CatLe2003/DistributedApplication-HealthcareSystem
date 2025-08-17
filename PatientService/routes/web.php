<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('home');
});

Route::get('/api/get-patient/{id}', [PatientController::class, 'show'])->name('patients.show');
//Route::get('/api/get-patient', [PatientController::class, 'index'])->name('patients.index');
//Route::post('/api/register-patient', action: [PatientController::class, 'register'])->name('patients.register');