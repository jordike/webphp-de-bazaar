<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('login.post');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerPost')->name('register.post');

    Route::get('/{company:name}/register', 'register')->name('company.register');
    Route::post('/{company:name}/register', 'registerPost')->name('company.register.post');
});

Route::middleware('auth')->group(function () {
    Route::resource('advertisement', AdvertisementController::class)->names('advertisement');

    Route::resource('company', CompanyController::class)->names('company');
    Route::resource('company.theme', ThemeController::class)->names('theme');

    Route::resource('companies', CompaniesController::class)->names('companies');
    Route::resource('companies.contracts', ContractController::class)->names('contracts');
    Route::get('companies/{company}/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/locale/{locale}', [LocaleController::class, '__invoke'])->name('locale.switch');

Route::view('/', 'home')->name('home');

Route::prefix('{company:name}')->group(function () {
    Route::get('/', [CompanyController::class, 'show'])->name('company.landing-page');
});
