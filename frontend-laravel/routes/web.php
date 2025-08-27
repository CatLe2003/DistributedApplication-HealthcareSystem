<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EmployeeController;

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthenticationController::class, 'registerAccount'])->name('register');

Route::get('/register_profile', function () {
    return view('auth.register_profile');
});

Route::post('/register_profile', [PatientController::class, 'registerProfile'])->name('profile.register');


// PATIENT'S UI
Route::get('/', function () {
    return view('dashboard.homepage');
}) ->name('home');

Route::get('/home', function () {
    return view('dashboard.homepage');
})->name('home');

Route::get('/department/list_departments', [EmployeeController::class, 'listDepartments']);

Route::get('/appointment/add_appt', function () {
    return view('appointment.add_appt');
});

Route::get('/appointment/detail_appt', function () {
    return view('appointment.detail_appt');
});

Route::get('/appointment/list_appts', function () {
    return view('appointment.list_appts');
});

Route::get('/appointment/payment_confirm', function () {
    return view('appointment.payment_confirm');
});

Route::get('/medical_record/profile', function () {
    return view('medical_record.profile');
});

Route::get('/medical_record/update_profile', function () {
    return view('medical_record.update_profile');
});

Route::get('/medical_record/medical_records', function () {
    return view('medical_record.medical_records');
});

Route::get('/medical_record/detail_medrecord', function () {
    return view('medical_record.detail_medrecord');
});
// DOCTOR'S UI
Route::get('/dashboard_doctor', function () {
    return view('layouts.doctor');
});

Route::get('/profile_employee', function () {
    return view('employee.profile_employee');
});

Route::get('/patients', function () {
    return view('employee.profile_employee');
});

Route::get('/schedule_management', function () {
    return view('employee.schedule_management');
});

Route::get('/patient_management', function () {
    return view('patient.list_patients');
});

Route::get('/detail_patient', function () {
    return view('patient.update_patient');
});

Route::get('/update_medicalrecord', function () {
    return view('patient.update_medrecord');
});

Route::get('/prescriptions', function () {
    return view('patient.prescriptions');
});

Route::get('/add_prescription', function () {
    return view('patient.add_prescription');
});

Route::get('/update_prescription', function () {
    return view('patient.update_prescription');
});
// STAFF'S UI

// ADMIN'S UI