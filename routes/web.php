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
    Route::get('advertisement/{advertisement}/favorite', [FavoriteController::class, 'favorite'])->name('favorites.favorite');
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('rent/{rentedProduct}/return', [RentController::class, 'return'])->name('advertisement.rent.return');
    Route::post('rent/{rentedProduct}/return', [RentController::class, 'storeReturn'])->name('advertisement.rent.storeReturn');

    Route::post('/advertisement/upload-csv', [AdvertisementController::class, 'uploadCsv'])->name('advertisement.uploadCsv');

    Route::resource('company', CompanyController::class)->names('company');
    Route::resource('company.theme', ThemeController::class)->names('theme');
    Route::post('company/{company}/theme/{theme}/use', [ThemeController::class, 'use'])->name('theme.use');
    Route::post('company/{company}/theme/{theme}/unuse', [ThemeController::class, 'unuse'])->name('theme.unuse');

    Route::resource('companies', CompaniesController::class)->names('companies');
    Route::resource('companies.contracts', ContractController::class)->names('contracts');
    Route::get('companies/{company}/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');

    Route::post('/companies/{company}/landing-page/add', [CompanyController::class, 'addLandingPageComponent'])->name('company.landing-page.add');
    Route::post('/companies/{company}/landing-page/order', [CompanyController::class, 'updateLandingPageComponentOrder'])->name('company.landing-page.order');
    Route::delete('/companies/{company}/landing-page/{component}', [CompanyController::class, 'deleteLandingPageComponent'])->name('company.landing-page.delete');

    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('advertisement.bid', BidController::class)->names('advertisement.bid');
    Route::patch('advertisement/{advertisement}/bid/accept/{bid}', [BidController::class, 'accept'])->name('advertisement.bid.accept');
    Route::patch('advertisement/{advertisement}/bid/reject/{bid}', [BidController::class, 'reject'])->name('advertisement.bid.reject');
    Route::get('advertisement/{advertisement}/bids', [BidController::class, 'showBids'])->name('advertisement.bid.show-bids');

    Route::post('advertisement/{advertisement}/review', [AdvertisementController::class, 'review'])->name('advertisement.review');

    Route::get('advertisement/advertiser/{advertiser}', [AdvertisementController::class, 'advertiser'])->name('advertisement.advertiser');
    Route::post('advertisement/advertiser/{advertiser}/review', [AdvertisementController::class, 'reviewAdvertiser'])->name('advertisement.advertiser.review');
    Route::post('advertisement/advertiser/{advertiser}/review/{review}/delete', [AdvertisementController::class, 'deleteReview'])->name('advertisement.advertiser.review.delete');
});

Route::get('/locale/{locale}', [LocaleController::class, '__invoke'])->name('locale.switch');
Route::get('/', HomeController::class)->name('home');

Route::prefix('{company:name}')->group(function () {
    Route::get('/', [CompanyController::class, 'show'])->name('company.landing-page');
});
