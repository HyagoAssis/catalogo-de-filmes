<?php

use function Pest\Laravel\getJson;

it('should be possible to search for a movie', function (){
    $request = getJson(route('search_movie'), [
        'query' => 'Vingadores',
    ]);

    $request->assertOk();

    $request->assertJsonFragment([
        'results' => []
    ]);
});

