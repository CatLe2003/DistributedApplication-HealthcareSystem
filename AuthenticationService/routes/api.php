<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/health', function () {
    return "Hello, this is the Authentication Service!";
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/verify-token', [AuthController::class, 'verifyToken']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::get('/users/{id}', [AuthController::class, 'getUserById']);
Route::patch('/users/{id}', [AuthController::class, 'updateUserById']);