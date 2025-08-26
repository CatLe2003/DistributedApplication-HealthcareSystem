<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\WeekdayController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShiftController;

Route::get('/', function () {
    return 'Appointment Service is running';
});

Route::get('/departments', [DepartmentController::class, 'getAllDepartments']);
Route::get('/departments/{id}', [DepartmentController::class, 'getDepartmentsById']);
Route::get('/departments/{id}/employees', [EmployeeController::class, 'getEmployeesByDepartmentId']);

Route::get('/doctors', [DoctorController::class, 'getAllDoctors']);
Route::get('/doctors/{id}', [DoctorController::class, 'getDoctorById']);
Route::get('/specialities/{id}/doctors', [DoctorController::class, 'getDoctorsBySpecialityId']);
Route::get('/rooms/{id}/doctors', [DoctorController::class, 'getDoctorsByRoomId']);
Route::get('/shifts/{id}/doctors', [DoctorController::class, 'getDoctorsByShiftId']);


Route::get('/employees', [EmployeeController::class, 'getAllEmployees']);
Route::get('/employees/{id}', [EmployeeController::class, 'getEmployeeById']);
Route::get('/staff', [EmployeeController::class, 'getAllStaff']);

Route::get('/rooms', [RoomController::class, 'getAllRooms']);
Route::get('/rooms/{id}', [RoomController::class, 'getRoomById']);

Route::get('/shifts', [ShiftController::class, 'getAllShifts']);
Route::get('/shifts/{id}', [ShiftController::class, 'getShiftById']);

Route::get('/specialities', [SpecialityController::class, 'getAllSpecialities']);
Route::get('/specialities/{id}', [SpecialityController::class, 'getSpecialityById']);

Route::get('/weekdays', [WeekdayController::class, 'getAllWeekdays']);
Route::get('/weekdays/{id}', [WeekdayController::class, 'getWeekdayById']);

Route::get('/doctor-schedules', [DoctorScheduleController::class, 'getAllSchedules']);
Route::get('/doctor-schedules/available', [DoctorScheduleController::class, 'getAvailableDoctors']);
Route::get('/doctor-schedules/{id}', [DoctorScheduleController::class, 'getScheduleById']);
Route::post('/doctor-schedules', [DoctorScheduleController::class, 'createSchedule']);
Route::put('/doctor-schedules/{id}', [DoctorScheduleController::class, 'updateSchedule']);
Route::delete('/doctor-schedules/{id}', [DoctorScheduleController::class, 'deleteSchedule']);

Route::get('/doctors/{doctorId}/schedules', [DoctorScheduleController::class, 'getSchedulesByDoctor']);
Route::get('/doctor-schedules/by-weekday/{weekdayId}', [DoctorScheduleController::class, 'getSchedulesByWeekday']);
Route::get('/doctor-schedules/by-shift/{shiftId}', [DoctorScheduleController::class, 'getSchedulesByShift']);
Route::post('/doctor-schedules/check-availability', [DoctorScheduleController::class, 'checkDoctorAvailability']);
