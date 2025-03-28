<?php

use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\ReservationController;
use App\Http\Controllers\v1\TableController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group( function () {

    Route::apiResource('customers', CustomerController::class);
    Route::get('tables/availables', [TableController::class, 'getAvailableTables'])->name('tables.availables');
    Route::apiResource('tables', TableController::class);
    Route::apiResource('reservations', ReservationController::class);

    Route::apiResource('users', UserController::class);

});