<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicalCaseApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/cases', [MedicalCaseApiController::class, 'index']);
    Route::post('/cases', [MedicalCaseApiController::class, 'store']);
    Route::get('/cases/{id}', [MedicalCaseApiController::class, 'show']);
    Route::put('/cases/{id}', [MedicalCaseApiController::class, 'update']);
    Route::delete('/cases/{id}', [MedicalCaseApiController::class, 'destroy']);
});
