<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\TestController;


Route::get('/', function () {
    return "Medical Catalog Service is running.";
});

 // Medicines
Route::prefix('medicines')->group(function () {
    Route::get('/', [MedicineController::class, 'index']);          
    Route::post('/', [MedicineController::class, 'store']);
    Route::get('/search', [MedicineController::class, 'search']);         
    Route::get('/{id}', [MedicineController::class, 'show']);      
    Route::patch('/{id}', [MedicineController::class, 'update']);    
    Route::delete('/{id}', [MedicineController::class, 'destroy']); 
});
// Forms
Route::prefix('forms')->group(function () {
    Route::get('/', [FormController::class, 'index']);
    Route::post('/', [FormController::class, 'store']);
    Route::get('/{id}', [FormController::class, 'show']);
    Route::patch('/{id}', [FormController::class, 'update']);
    Route::delete('/{id}', [FormController::class, 'destroy']);
});
// Units
Route::prefix('units')->group(function () {
    Route::get('/', [UnitController::class, 'index']);  // all
    Route::post('/', [UnitController::class, 'store']);
    Route::get('/{id}', [UnitController::class, 'show']);
    Route::patch('/{id}', [UnitController::class, 'update']);
    Route::delete('/{id}', [UnitController::class, 'destroy']);
});
// Manufacturers
Route::prefix('manufacturers')->group(function () {
    Route::get('/', [ManufacturerController::class, 'index']);
    Route::post('/', [ManufacturerController::class, 'store']);
    Route::get('/{id}', [ManufacturerController::class, 'show']);
    Route::patch('/{id}', [ManufacturerController::class, 'update']);
    Route::delete('/{id}', [ManufacturerController::class, 'destroy']);
});
// Tests
Route::prefix('tests')->group(function () {
    Route::get('/', [TestController::class, 'index']); 
    Route::post('/', [TestController::class, 'store']);
    Route::get('/{id}', [TestController::class, 'show']);
    Route::patch('/{id}', [TestController::class, 'update']);
    Route::delete('/{id}', [TestController::class, 'destroy']);
});