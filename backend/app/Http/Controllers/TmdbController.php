<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMovieRequest;
use App\Libs\TMDB\TmdbClient;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class TmdbController extends Controller
{
    public function searchMovies(SearchMovieRequest $request): JsonResponse
    {
        $user = $request->user();
        $page = $request->input('page', 2);

        $data = TmdbClient::getInstance()->searchMovie($request->get('query'), $page);

        if ($data['results'] ?? null) {
            foreach ($data['results'] as &$movie) {
                $movie['is_favorite'] = $user ? $user->favoriteMovies()->where('movie_db_id',
                    $movie['id'])->exists() : false;
                $movie['genres'] = Genre::whereIn('movie_db_id', $movie['genre_ids'])->get()->toArray();
            }
        }

        return response()->json($data);
    }
}
