<?php

use App\Models\FavoriteMovie;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;

it('should be able to list a favorite movie', function () {
    Sanctum::actingAs(User::factory()->create());

    $favoriteMovie = FavoriteMovie::factory()->create();

    $request = getJson(route('favorite_movie.index'))
        ->assertOk();

    $request->assertJsonFragment([
        'id' => $favoriteMovie->id,
        'name' => $favoriteMovie->name,
        'movie_db_id' => $favoriteMovie->movie_db_id,
        'user_id' => $favoriteMovie->user_id,
        'created_at' => $favoriteMovie->created_at,
        'updated_at' => $favoriteMovie->updated_at,
    ]);
});
