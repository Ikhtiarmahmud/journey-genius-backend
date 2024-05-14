<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::post('/send-otp', [App\Http\Controllers\RegistrationController::class, 'sendOtp']);
    Route::post('/verify-otp', [App\Http\Controllers\RegistrationController::class, 'verifyOtp']);
});

Route::post('/save', [App\Http\Controllers\UserController::class, 'save']);
