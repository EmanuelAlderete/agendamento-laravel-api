<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/appointments', AppointmentController::class);
    Route::apiResource('/services', ServiceController::class);
});
