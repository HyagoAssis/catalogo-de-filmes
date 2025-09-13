<?php

use App\Http\Controllers\FavoriteMovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/favorite_movie', [FavoriteMovieController::class, 'store'])->name('favorite_movie.store');
Route::delete('/favorite_movie/{favoriteMovie}', [FavoriteMovieController::class, 'destroy'])->name('favorite_movie.delete');
Route::get('/favorite_movie', [FavoriteMovieController::class, 'index'])->name('favorite_movie.index');
