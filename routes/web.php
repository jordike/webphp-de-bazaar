<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginPost')->name('login.post');

        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'registerPost')->name('register.post');

        Route::get('/{company:name}/register', 'register')->name('company.register');
        Route::post('/{company:name}/register', 'registerPost')->name('company.register.post');
    });
});

Route::middleware('auth')->group(function () {
    Route::resource('advertisement', AdvertisementController::class)->names('advertisement');
    Route::resource('company', CompanyController::class)->names('company');
    Route::resource('companies', CompaniesController::class)->names('companies');

    Route::post('/logout', [ AuthController::class, 'logout' ])->name('logout');
});

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', function () {
    return view('index');
})->name('home');
