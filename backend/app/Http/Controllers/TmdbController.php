<?php

namespace App\Http\Controllers;

use App\Libs\TMDB\TmdbClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TmdbController extends Controller
{
    public function searchMovies(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);

        $data = TmdbClient::getInstance()->searchMovie($request->get('query'), $request->get('page_size', 10), $page);

        return response()->json($data);
    }
}
