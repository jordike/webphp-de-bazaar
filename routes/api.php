<?php

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AdvertisementController::class)->prefix('advertisements')->group(function() {
        Route::get('/get-all', 'getAllAdvertisements')->name('api.advertisements.get-all');
        Route::get('/get/{advertisement}', 'getAdvertisement')->name('api.advertisements.get');
    });
});

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
