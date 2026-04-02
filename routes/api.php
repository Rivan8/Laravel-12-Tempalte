<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\ProgressController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Kelas Routes
    Route::get('/kelas', [KelasController::class, 'index']);
    Route::get('/kelas/{id}', [KelasController::class, 'show']);
    Route::post('/kelas/{id}/enroll', [KelasController::class, 'enroll']);
    Route::get('/my-kelas', [KelasController::class, 'myClasses']);

    // Progress tracking (same as web, but auth via sanctum token)
    Route::post('/materi/{materi_id}/complete', [ProgressController::class, 'markComplete']);
});
