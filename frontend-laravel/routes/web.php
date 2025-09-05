<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MedicalCatalogController;

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthenticationController::class, 'registerAccount'])->name('register');

Route::get('/register_profile', function () {
    return view('auth.register_profile');
});

Route::post('/register_profile', [PatientController::class, 'registerProfile'])->name('profile.register');

Route::post('/update_profile', [PatientController::class, 'updateProfile'])->name('profile.update');

// PATIENT'S UI
Route::get('/',  function () {
    return view('auth.login');
});

Route::get('/home', [EmployeeController::class, 'listDepartmentsHome'])->name('home');

Route::get('/department/list_departments', [EmployeeController::class, 'listDepartments']);

Route::get('/appointment/add_appt', [AppointmentController::class, 'showBookingForm']);
Route::post('/appointment/add_appt', [AppointmentController::class, 'createAppointment'])->name('appointment.create');

Route::get('/appointment/detail_appt', function () {
    return view('appointment.detail_appt');
});

Route::get('/appointment/list_appts', [AppointmentController::class, 'getAppointmentsByPatient'])->name('appointment.list_appts');

// Route::get('/appointment/payment_confirm', function () {
//     return view('appointment.payment_confirm');
// });

Route::get('/medical_record/profile', [PatientController::class, 'getProfile'])->name('medical_record.profile');

Route::put('/medical_record/update_profile', [PatientController::class, 'updateProfile'])->name('medical_record.update_profile');

Route::get('/medical_record/update_profile', [PatientController::class, 'getProfileBeforeUpdate'])->name('medical_record.get_update_profile');

Route::get('/medical_record/medical_records', [PatientController::class, 'getMedicalVisits'])->name('medical_record.medical_records');

Route::get('/medical_record/detail_medrecord/{id}', [PatientController::class, 'getMedicalVisitDetail'])->name('medical_record.detail_medrecord');
// DOCTOR'S UI
Route::get('/dashboard_doctor', function () {
    return view('layouts.doctor');
})->name('dashboard_doctor');

Route::get('/profile_doctor', function () {
    return view('employee.profile_doctor');
})->name('profile_doctor');

Route::get('/patients', function () {
    return view('employee.patients');
})->name('patients');

Route::get('/schedule_management', [EmployeeController::class, 'getSchedulesByDoctor'])->name('employee.schedule_management');

Route::get('/employee/add_schedule', [EmployeeController::class, 'getAllShifts'])->name('employee.add_schedule');

Route::post('/employee/add_schedule', [EmployeeController::class, 'addSchedule'])->name('employee.add_schedule.post');

Route::delete('/delete_schedule/{id}', [EmployeeController::class, 'deleteSchedule'])->name('employee.delete_schedule');

Route::get('/patient_management', [PatientController::class, 'getAll'])->name('patient_management');

Route::get('/medvisit_staff', [PatientController::class, 'getAllMedicalVisits'])->name('medvisit_staff');

Route::get('/medical_record/detail_medvisit_staff/{id}', [PatientController::class, 'getMedicalVisitDetailStaff'])->name('medical_record.detail_medvisit_staff');

Route::get('/add_medvisit', [PatientController::class, 'showAddMedVisitForm'])->name('add_medvisit');

Route::get('/api/doctor/{doctorId}/department', [PatientController::class, 'getDepartmentByDoctor']);

Route::post('/add_medvisit', [PatientController::class, 'createMedVisit'])->name('add_medvisit.post');

Route::get('patient/detail_patient/{id}', [PatientController::class, 'getDetailPatient'])->name('detail_patient');

Route::post('patient/detail_patient/{id}', [PatientController::class, 'updateDetailPatient'])->name('detail_patient.update');

Route::get('/update_medicalrecord', function () {
    return view('patient.update_medrecord');
});

Route::get('/add_schedule', function () {
    return view('employee.add_schedule');
});

Route::get('/appointment_management', [AppointmentController::class, 'getAppointmentsByDoctor'])->name('appointment_management');

// STAFF'S UI
Route::get('/profile_employee', function () {
    return view('employee.profile_employee');
})->name('profile_employee');

Route::get('/prescriptions', [PatientController::class, 'getAllPrescriptions'])->name('prescriptions');

Route::get('/add_prescription/{visit_id}', [PatientController::class, 'showAddForm'])
    ->name('add_prescription');

Route::post('/add_prescription', [PatientController::class, 'createPrescription'])->name('prescription.createPrescription');

Route::get('/update_prescription', function () {
    return view('patient.update_prescription');
});

Route::get('/patient/detail_prescription/{id}', [PatientController::class, 'getPrescriptionDetail'])->name('detail_prescription');

Route::get('/appointment_management_staff', [AppointmentController::class, 'getAllAppointments'])->name('appointment_management.staff');

Route::get('/add_appointment', function () {
    return view('appointment.add_appt_staff');
});

// ADMIN'S UI
Route::get('/medicine_management', [MedicalCatalogController::class, 'listMedicines'])->name('medicine_management');

Route::get('/add_medicine', [MedicalCatalogController::class, 'showAddMedicineForm'])->name('add_medicine');

Route::post('/add_medicine', [MedicalCatalogController::class, 'addMedicine'])->name('medicine.add');

Route::delete('/delete_medicine/{id}', [MedicalCatalogController::class, 'deleteMedicine'])->name('medicine.delete');

Route::get('/statistical_report', [PatientController::class, 'getStatisticalReport'])->name('statistical_report');
