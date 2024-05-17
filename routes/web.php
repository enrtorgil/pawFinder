<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('index');
})->name('index');

// Rutas para el inicio de sesión y el registro en el mismo controladorS
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [LoginController::class, 'register']);
