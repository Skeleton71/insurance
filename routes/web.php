<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;

// Редирект с главной страницы на owners
Route::get('/', function () {
    return redirect()->route('owners.index');
});

Route::resource('owners', OwnerController::class);