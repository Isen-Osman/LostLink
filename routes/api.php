<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1,login');

Route::apiResource('reports', ReportController::class)
    ->only(['index', 'show'])
    ->names('api.reports')
    ->middleware('throttle:60,1,api');

Route::middleware(['auth:sanctum', 'throttle:60,1,api'])->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('reports', ReportController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.reports');
});
