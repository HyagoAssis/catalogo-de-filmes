<?php

use App\Models\FavoriteMovie;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a favorite movie', function () {
    $user = User::factory()->create();
    $favoriteMovie = FavoriteMovie::factory()->create();

    Sanctum::actingAs($user);

    deleteJson(route('favorite_movie.delete', $favoriteMovie))->assertOk();

    assertDatabaseMissing('favorite_movies', $favoriteMovie->toArray());
});

it('should be able to delete a favorite movie by movie_db_id', function () {
    $user = User::factory()->create();
    $favoriteMovie = FavoriteMovie::factory()->create(
        ['user_id' => $user->id]
    );

    Sanctum::actingAs($user);

    deleteJson(route('favorite_movie.delete_by_movie_db_id', $favoriteMovie->movie_db_id))->assertOk();

    assertDatabaseMissing('favorite_movies', $favoriteMovie->toArray());
});
