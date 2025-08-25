<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return 'Appointment Service is running';
});

Route::get('/departments', [DepartmentController::class, 'getAllDepartments']);
Route::get('/departments/{id}', [DepartmentController::class, 'getDepartmentById']);
