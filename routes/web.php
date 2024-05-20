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

Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users')->middleware(['auth', 'isAdmin']);
Route::get('/admin/publications', [AdminController::class, 'publications'])->name('admin.publications')->middleware(['auth', 'isAdmin']);
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports')->middleware(['auth', 'isAdmin']);

Route::get('publications/my', [PublicationController::class, 'myPublications'])->name('publications.my');
Route::post('/publications/{publication}/favorite', [FavController::class, 'favorite'])->name('publications.favorite');
Route::post('/publications/{publication}/report', [ReportController::class, 'report'])->name('publications.report');
Route::get('/messages/unread-count', [TextController::class, 'unreadCount'])->name('messages.unreadCount');
Route::post('/texts/{id}/toggle-read', [TextController::class, 'toggleRead'])->name('texts.toggleRead');
Route::delete('/reports/{publication_id}/{user_id}/{created_at}', [ReportController::class, 'destroy'])->name('reports.destroy');

Route::resource('texts', TextController::class)->middleware('auth');
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('publications', PublicationController::class)->middleware('auth');
Route::resource('reports', ReportController::class)->middleware('auth');
