<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\FavController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TextController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/', [LoginController::class, 'index'])->name('index');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [LoginController::class, 'register']);

Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index')->middleware(['auth', 'isAdmin']);
Route::get('publications/my', [PublicationController::class, 'myPublications'])->name('publications.my');
Route::post('/publications/{publication}/favorite', [FavController::class, 'favorite'])->name('publications.favorite');
Route::post('/publications/{publication}/report', [ReportController::class, 'report'])->name('publications.report');

Route::resource('texts', TextController::class)->middleware('auth');
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('publications', PublicationController::class)->middleware('auth');

