<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\ReservationController;
use App\Http\Controllers\v1\TableController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api')->group( function() {

    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to my Restaurant Reservation System API',
            'version' => '1.0.0',
        ]);
    });

    // Customers
    Route::apiResource('customers', CustomerController::class)
            ->middleware('permission:view customers|create customers|edit customers|delete customers');

    // Tables
    Route::get('tables/availables', [TableController::class, 'getAvailableTables'])->name('tables.availables')
            ->middleware('permission:view available tables');
    Route::patch('tables/{table}/release', [TableController::class, 'release'])->name('tables.release')
            ->middleware('permission:release tables');
    Route::patch('tables/{table}/occupied', [TableController::class, 'occupied'])->name('tables.occupied')
            ->middleware('permission:occupy tables');
    Route::apiResource('tables', TableController::class)
            ->middleware(['permission:view tables|create tables|edit tables|delete tables']);

    Route::patch('reservations/{reservation}/completed', [ReservationController::class, 'completed'])->name('reservation.completed')
            ->middleware('permission:complete reservations');
    Route::patch('reservations/{reservation}/cancelled', [ReservationController::class, 'cancelled'])->name('reservation.cancelled')
            ->middleware('permission:cancel reservations');
    Route::apiResource('reservations', ReservationController::class)
            ->middleware(['permission:view reservations|create reservations|edit reservations|delete reservations']);            

    Route::patch('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password')
            ->middleware(['password.change']);
    Route::post('users/get-by-email', [UserController::class, 'getByEmail'])->name('users.get-by-email')
            ->middleware('permission:view users');
    Route::apiResource('users', UserController::class)->middleware('protected.admin')
            ->middleware(['permission:view users|create users|edit users|delete users']);

    Route::prefix('auth')->group( function() {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::post('me', [AuthController::class, 'me'])->name('auth.me');
    });

});
