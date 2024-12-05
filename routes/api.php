<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/notification', [\App\Http\Controllers\MainController::class ,'notification'])->name('notification');

Route::post('/payment-notification', [\App\Http\Controllers\MainController::class ,'paymentNotification'])->name('payment-notification');