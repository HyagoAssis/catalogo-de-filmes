<?php

use function Pest\Laravel\getJson;

it('should be possible to search for a movie', function () {
    $request = getJson(route('search_movie', [
        'query' => 'Vingadores',
    ]));

    $request->assertOk();
    $responseData = $request->json();

    $this->assertNotEmpty($responseData['results'], 'O array results não deve estar vazio');
});

describe('validation rules', function () {
    test('query:required', function () {
        getJson(route('search_movie'))->assertJsonValidationErrors(['query' => 'required']);
    });
});

