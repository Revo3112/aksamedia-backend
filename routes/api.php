<?php
// routes/api.php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;

// Route yang hanya bisa diakses ketika belum login
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Route yang hanya bisa diakses ketika sudah login
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index']);

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
