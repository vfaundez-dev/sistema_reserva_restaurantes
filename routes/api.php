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
    Route::patch('tables/{table}/release', [TableController::class, 'release'])->name('tables.release');
    Route::patch('tables/{table}/occupied', [TableController::class, 'occupied'])->name('tables.occupied');
    Route::apiResource('tables', TableController::class);
    Route::patch('reservations/{reservation}/cancelled', [ReservationController::class, 'cancelled'])->name('reservation.cancelled');
    Route::apiResource('reservations', ReservationController::class);

    Route::apiResource('users', UserController::class);

});