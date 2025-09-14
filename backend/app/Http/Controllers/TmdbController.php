<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMovieRequest;
use App\Libs\TMDB\TmdbClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TmdbController extends Controller
{
    public function searchMovies(SearchMovieRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);

        $data = TmdbClient::getInstance()->searchMovie($request->query, $page);

        return response()->json($data);
    }
}
