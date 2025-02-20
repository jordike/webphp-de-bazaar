<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::get("/login", "login")->name("login");
    Route::post("/login", "loginPost");

    Route::get("/register", "register")->name("register");
    Route::post("/register", "registerPost");

    Route::post("/logout", "logout")->name("logout");
});

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', function () {
    return view('index');
})->name('home');
