<?php

use App\Http\Controllers\v1\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group( function () {

    Route::apiResource('customers', CustomerController::class);

});