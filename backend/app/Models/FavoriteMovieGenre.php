<?php

namespace App\Models;

class FavoriteMovieGenre extends BaseModel
{
    protected $table = 'favorite_movie_genres';

    protected $fillable = ['favorite_movie_id', 'genre_id'];
}
