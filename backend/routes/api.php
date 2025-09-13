<?php

use App\Http\Controllers\FavoriteMovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/favorite_movie', [FavoriteMovieController::class, 'store'])->name('favorite_movie.store');
