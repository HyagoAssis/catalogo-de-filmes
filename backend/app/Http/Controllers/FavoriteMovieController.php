<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteMovie\StoreRequest;
use App\Http\Resources\FavoriteMovieResource;
use App\Models\FavoriteMovie;

class FavoriteMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FavoriteMovie::query()->paginate();

        return FavoriteMovieResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = $request->user();
        $genres = $request->genres;

        $favoriteMovie = $user->favoriteMovies()->create([
            'name' => $request->name,
            'movie_db_id' => $request->movie_db_id,
            'overview' => $request->overview,
            'poster_path' => $request->poster_path,
            'release_date' => $request->release_date,

        ]);

        $favoriteMovie->genres()->attach($genres);

        return FavoriteMovieResource::make($favoriteMovie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteMovie $favoriteMovie): \Illuminate\Http\JsonResponse
    {
        $deleted = $favoriteMovie->delete();

        return response()->json([
            'message' => $deleted ? 'Filme favorito removido' : 'Erro ao remover filme favorito',
        ], $deleted ? 200 : 500);

    }
}
