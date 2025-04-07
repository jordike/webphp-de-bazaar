<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('login.post');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerPost')->name('register.post');
    Route::get('/{company:name}/register', 'register')->name('company.register');
    Route::post('/{company:name}/register', 'registerPost')->name('company.register.post');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Advertisement Routes
    Route::prefix('advertisements')->name('advertisement.')->group(function () {
        Route::get('my-advertisements', [AdvertisementController::class, 'myAdvertisements'])->name('my-advertisements');
        Route::resource('/advertisement', AdvertisementController::class)->names('');
        Route::get('{advertisement}/favorite', [FavoriteController::class, 'favorite'])->name('favorites.favorite');
        Route::post('upload-csv', [AdvertisementController::class, 'uploadCsv'])->name('uploadCsv');
        Route::post('{advertisement}/review', [AdvertisementController::class, 'review'])->name('review');
        Route::get('advertiser/{advertiser}', [AdvertisementController::class, 'advertiser'])->name('advertiser');
        Route::post('advertiser/{advertiser}/review', [AdvertisementController::class, 'reviewAdvertiser'])->name('advertiser.review');
        Route::post('advertiser/{advertiser}/review/{review}/delete', [AdvertisementController::class, 'deleteReview'])->name('advertiser.review.delete');

        // Bid Routes
        Route::prefix('{advertisement}/bid')->name('bid.')->group(function () {
            Route::resource('/', BidController::class)->names('');
            Route::patch('accept/{bid}', [BidController::class, 'accept'])->name('accept');
            Route::patch('reject/{bid}', [BidController::class, 'reject'])->name('reject');
            Route::get('/', [BidController::class, 'showBids'])->name('show-bids');
        });
    });

    // Favorite Routes
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Rent Routes
    Route::prefix('rent/{rentedProduct}')->name('advertisement.rent.')->group(function () {
        Route::get('return', [RentController::class, 'return'])->name('return');
        Route::post('return', [RentController::class, 'storeReturn'])->name('storeReturn');
    });

    // Company Routes
    Route::resource('company', CompanyController::class)->names('company');
    Route::resource('company.theme', ThemeController::class)->names('theme');
    Route::post('company/{company}/theme/{theme}/use', [ThemeController::class, 'use'])->name('theme.use');
    Route::post('company/{company}/theme/{theme}/unuse', [ThemeController::class, 'unuse'])->name('theme.unuse');
    Route::post('companies/{company}/landing-page/add', [CompanyController::class, 'addLandingPageComponent'])->name('company.landing-page.add');
    Route::post('companies/{company}/landing-page/order', [CompanyController::class, 'updateLandingPageComponentOrder'])->name('company.landing-page.order');
    Route::delete('companies/{company}/landing-page/{component}', [CompanyController::class, 'deleteLandingPageComponent'])->name('company.landing-page.delete');

    // Companies and Contracts Routes
    Route::resource('companies', CompaniesController::class)->names('companies');
    Route::resource('companies.contracts', ContractController::class)->names('contracts');
    Route::get('companies/{company}/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');

    // Agenda Routes
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Locale Switch Route
Route::get('/locale/{locale}', [LocaleController::class, '__invoke'])->name('locale.switch');

// Home Route
Route::get('/', HomeController::class)->name('home');

// Company Landing Page Route
Route::prefix('{company:name}')->group(function () {
    Route::get('/', [CompanyController::class, 'show'])->name('company.landing-page');
});
