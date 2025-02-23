<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;

Route::get('/user', function (Request $request) {
    return $request->usber();
})->middleware(Authenticate::using('sanctum'));

Route::apiResource('/tours', App\Http\Controllers\Api\TourController::class);
Route::apiResource('/bookings', App\Http\Controllers\Api\BookingController::class);


// Endpoint untuk daftar tours (dropdown)
Route::get('/bookings/tours', [BookingController::class, 'getToursForDropdown']);
