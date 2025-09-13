<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteMovie\StoreRequest;
use App\Http\Resources\FavoriteMovieResource;
use App\Models\FavoriteMovie;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = $request->user();

        $favoriteMovie = $user->favoriteMovies()->create([
            'name' => $request->name,
            'movie_db_id' => $request->movie_db_id,
        ]);

        return FavoriteMovieResource::make($favoriteMovie);
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteMovie $favoriteMovie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteMovie $favoriteMovie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FavoriteMovie $favoriteMovie)
    {
        //
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
