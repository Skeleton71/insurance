<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerApiController;
use App\Http\Controllers\CarApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('owners', OwnerApiController::class);

Route::apiResource('cars', CarApiController::class);