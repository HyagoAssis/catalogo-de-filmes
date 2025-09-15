<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMovieRequest;
use App\Libs\TMDB\TmdbClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TmdbController extends Controller
{
    public function searchMovies(SearchMovieRequest $request): JsonResponse
    {
        $user = $request->user();
        $page = $request->input('page', 1);

        $data = TmdbClient::getInstance()->searchMovie($request->get('query'), $page);

        if ($data['results'] ?? null) {
            foreach ($data['results'] as &$movie) {
                $movie['is_favorite'] = $user ? $user->favoriteMovies()->where('movie_db_id',
                    $movie['id'])->exists() : false;
            }
        }

        return response()->json($data);
    }
}
