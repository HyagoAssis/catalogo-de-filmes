<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be able to store a new favorite movie', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('favorite_movie.store'), [
        'name' => 'Filme Teste',
        'movie_db_id' => 2,
    ])->assertSuccessful();

    assertDatabaseHas('favorite_movies', ['name' => 'Filme Teste', 'movie_db_id' => 2, 'user_id' => $user->id]);
});

describe('validation rules', function () {
    test('name:required', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('favorite_movie.store'), [
            'name' => 'Filme',
            'movie_db_id' => 2,
        ])->assertJsonValidationErrors(['name' => 'required']);
    });

    test('movie_db_id:required', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('favorite_movie.store'), [
            'name' => 'Filme Teste',
        ])->assertJsonValidationErrors(['movie_db_id' => 'required']);
    });

    test('movie_db_id:unique', function () {
        $user = User::factory()->create();

        $user->favoriteMovies()->create(['name' => 'Filme', 'movie_db_id' => 2]);

        Sanctum::actingAs($user);

        postJson(route('favorite_movie.store'), [
            'name' => 'Filme',
            'movie_db_id' => 2,
        ])->assertJsonValidationErrors(['movie_db_id' => 'Filme já favoritado pelo usuário']);;
    });
});
