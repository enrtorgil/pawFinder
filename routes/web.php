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

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/publications', [AdminController::class, 'publications'])->name('admin.publications');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

Route::middleware('auth')->group(function () {
    Route::get('publications/my', [PublicationController::class, 'myPublications'])->name('publications.my');
    Route::post('/publications/{publication}/report', [ReportController::class, 'report'])->name('publications.report');
    Route::post('publications/{publication}/favorite', [UserController::class, 'favorite'])->name('publications.favorite');
    Route::delete('publications/{publication}/favorite', [UserController::class, 'unfavorite'])->name('publications.unfavorite');
    Route::get('favs', [FavController::class, 'index'])->name('favs.index');

    Route::get('/messages/unread-count', [TextController::class, 'unreadCount'])->name('messages.unreadCount');
    Route::post('/texts/{id}/toggle-read', [TextController::class, 'toggleRead'])->name('texts.toggleRead');
    Route::delete('/reports/{publication_id}/{user_id}/{created_at}', [ReportController::class, 'destroy'])->name('reports.destroy');

    Route::resource('texts', TextController::class);
    Route::resource('users', UserController::class);
    Route::resource('publications', PublicationController::class);
    Route::resource('reports', ReportController::class);
});
