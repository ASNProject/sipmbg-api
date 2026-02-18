<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AttendanceExportController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'userProfile']);
});

// School routes
Route::apiResource('schools', SchoolController::class);

// Student routes
Route::apiResource('students', StudentController::class);

// Attendance routes
Route::get('/attendances', [AttendanceController::class, 'index']);
Route::post('/attendances/{fingerprint_id}', [AttendanceController::class, 'store']);
Route::get('/attendances/{id}', [AttendanceController::class, 'show']);
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']);

// Attendance export route
Route::get('/export', [AttendanceExportController::class, 'export']);