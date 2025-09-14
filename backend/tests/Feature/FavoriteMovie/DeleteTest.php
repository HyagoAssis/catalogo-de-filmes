<?php

use App\Models\FavoriteMovie;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a favorite movie', function () {
    $favoriteMovie = FavoriteMovie::factory()->create();

    deleteJson(route('favorite_movie.delete', $favoriteMovie))->assertOk();

    assertDatabaseMissing('favorite_movies', $favoriteMovie->toArray());
});
