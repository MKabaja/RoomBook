<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;

use Illuminate\Support\Facades\Route;

// Auth routes

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/rooms', [RoomController::class, 'index']);

    Route::controller(BookingController::class)->group(function () {
        Route::get('/bookings', 'index');
        Route::post('/bookings', 'store');
        Route::patch('/bookings/{booking}/cancel', 'cancel');
    });
});
