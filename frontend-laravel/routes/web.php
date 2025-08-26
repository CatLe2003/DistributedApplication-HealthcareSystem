<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// PATIENT'S UI
Route::get('/', function () {
    return view('dashboard.homepage');
}) ->name('home');

Route::get('/home', function () {
    return view('dashboard.homepage');
})->name('home');

Route::get('/department/list_departments', function () {
    return view('department.list_departments');
});

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

Route::post('/medical_record/update_profile', [PatientController::class, 'updateProfile'])->name('profile.update');

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
// STAFF'S UI

// ADMIN'S UI