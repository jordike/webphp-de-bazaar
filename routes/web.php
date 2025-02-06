<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix("/auth")->name("auth.")->group(function() {
    Route::get("/login", "login")->name("login");
    Route::post("/login", "loginPost");

    Route::get("/register", "register")->name("register");
    Route::post("/register", "registerPost");
});

Route::get('/', function () {
    return view('index');
})->name('home');
