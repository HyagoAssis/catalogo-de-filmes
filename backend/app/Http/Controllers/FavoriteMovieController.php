<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteMovie\StoreRequest;
use App\Http\Resources\FavoriteMovieResource;
use App\Models\FavoriteMovie;
use App\Models\Genre;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FavoriteMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $data = $user->favoriteMovies()->paginate();

        return FavoriteMovieResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $request->user();

            $genres = $request->genres;
            $genresFromTable = Genre::whereIn('movie_db_id', $genres)->pluck('id')->toArray();

            $favoriteMovie = $user->favoriteMovies()->create([
                'name' => $request->name,
                'movie_db_id' => $request->movie_db_id,
                'overview' => $request->overview,
                'poster_path' => $request->poster_path,
                'release_date' => $request->release_date,

            ]);

            $favoriteMovie->genres()->attach($genresFromTable);

            DB::commit();

            return FavoriteMovieResource::make($favoriteMovie);
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteMovie $favoriteMovie): JsonResponse
    {
        $deleted = $favoriteMovie->delete();

        return response()->json([
            'message' => $deleted ? 'Filme favorito removido' : 'Erro ao remover filme favorito',
        ], $deleted ? 200 : 500);
    }

    public function deleteByMovieDbId($movieDbId): JsonResponse
    {
        $user = auth()->user();

        $deleted = $user->favoriteMovies()->where(FavoriteMovie::column('movie_db_id'), $movieDbId)->delete();

        return response()->json([
            'message' => $deleted ? 'Filme favorito removido' : 'Erro ao remover filme favorito',
        ], $deleted ? 200 : 500);
    }
}
