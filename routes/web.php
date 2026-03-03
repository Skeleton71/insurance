<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::resource('owners', OwnerController::class);
Route::resource('cars', CarController::class);

Route::get('/', function () {
    return redirect()->route('cars.index');
});