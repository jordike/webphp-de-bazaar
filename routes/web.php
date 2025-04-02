<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginPost');

        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'registerPost');
    });
});

Route::middleware('auth')->group(function () {
    Route::resource('advertisement', AdvertisementController::class)->names('advertisement');
    Route::resource('company', CompanyController::class)->names('company');

    Route::post('/logout', [ AuthController::class, 'logout' ])->name('logout');
});

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', function () {
    return view('index');
})->name('home');
