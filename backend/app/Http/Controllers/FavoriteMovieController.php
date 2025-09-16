<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteMovie\StoreRequest;
use App\Http\Resources\FavoriteMovieResource;
use App\Models\FavoriteMovie;
use App\Models\FavoriteMovieGenre;
use App\Models\Genre;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $querySearch = $request->get('query');
        $genreId = $request->get('genre_id');

        $data = $user
            ->favoriteMovies()
            ->when($querySearch, function ($query, $querySearch) {
                $query->where(FavoriteMovie::column('name'), 'like', '%'.$querySearch.'%');
            })
            ->when($genreId, function ($query, $genreId) {
                $query
                    ->join(FavoriteMovieGenre::table(), FavoriteMovie::column('id'),
                        FavoriteMovieGenre::column('favorite_movie_id'))
                    ->where(FavoriteMovieGenre::column('genre_id'), '=', $genreId);
            })
            ->groupBy(FavoriteMovie::column('id'))
            ->with('genres')
            ->select(FavoriteMovie::column('*'))
            ->paginate();

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
