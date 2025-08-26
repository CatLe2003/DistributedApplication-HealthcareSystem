<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;


Route::get('/', function () {
    return response()->json(['status' => 'Appointment Service is running']);
});

Route::prefix('appointments')->group(function () {
    Route::post('/', [AppointmentController::class, 'store']);                // Create
    Route::get('/', [AppointmentController::class, 'index']);                 // Get all
    Route::get('/is-slot-available', [AppointmentController::class, 'isSlotAvailable']); // Check slot availability
    Route::get('/{id}', [AppointmentController::class, 'show']);              // Get detail
    Route::put('/{id}', [AppointmentController::class, 'update']);            // Update
    Route::delete('/{id}', [AppointmentController::class, 'destroy']);        // Delete

    Route::get('/doctor/search', [AppointmentController::class, 'searchByDateAndDoctor']); // Search by date and doctor
    Route::get('/patient/search', [AppointmentController::class, 'searchByDateAndPatient']); // Search by date and patient
    Route::get('/patient/{patientId}', [AppointmentController::class, 'getByPatient']); // Get by patient
    Route::get('/doctor/{doctorId}', [AppointmentController::class, 'getByDoctor']); // Get by doctor
    Route::get('/date/{date}', [AppointmentController::class, 'getByDate']); // Get by date
});