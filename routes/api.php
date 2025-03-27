<?php

use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\ReservationController;
use App\Http\Controllers\v1\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group( function () {

    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('tables', TableController::class);
    Route::apiResource('reservations', ReservationController::class);

});