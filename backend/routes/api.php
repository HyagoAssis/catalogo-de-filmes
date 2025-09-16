<?php

use App\Http\Controllers\FavoriteMovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TmdbController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/favorite_movie', [FavoriteMovieController::class, 'store'])->name('favorite_movie.store');
    Route::delete('/favorite_movie/{favoriteMovie}',
        [FavoriteMovieController::class, 'destroy'])->name('favorite_movie.delete');
    Route::delete('/favorite_movie/delete_by_movie_db_id/{movieDbId}',
        [FavoriteMovieController::class, 'deleteByMovieDbId'])->name('favorite_movie.delete_by_movie_db_id');
    Route::get('/favorite_movie', [FavoriteMovieController::class, 'index'])->name('favorite_movie.index');
});

Route::get('/search_movie', [TmdbController::class, 'searchMovies'])->name('search_movie');
Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');
