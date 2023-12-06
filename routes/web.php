<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('movies/{movie}/reviews/create', [ReviewController::class, 'create'])->name('movies.reviews.create');
Route::post('movies/{movie}/reviews', [ReviewController::class, 'store'])->name('movies.reviews.store');

Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/add-movie', [AdminController::class, 'showAddMovieForm'])->name('admin.add_movie');
    Route::post('/admin/add-movie', [AdminController::class, 'addMovie']);
    Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/admin/movie_form/{id?}', [AdminController::class, 'showMovieForm'])->name('admin.movie_form');
    Route::post('/admin/save_movie/{id?}', [AdminController::class, 'saveMovie'])->name('admin.save_movie');
    Route::get('/admin/delete_movie/{id}', [AdminController::class, 'deleteMovie'])->name('admin.delete_movie');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
