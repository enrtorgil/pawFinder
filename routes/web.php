<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicationController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/', [LoginController::class, 'index'])->name('index');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [LoginController::class, 'register']);

Route::get('publications/my', [PublicationController::class, 'myPublications'])->name('publications.my');
Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

Route::resource('users', UserController::class)->middleware('auth');
Route::resource('publications', PublicationController::class)->middleware('auth');

