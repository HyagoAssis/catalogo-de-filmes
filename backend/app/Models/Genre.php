<?php

namespace App\Models;

use App\Libs\TMDB\TmdbClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /** @use HasFactory<\Database\Factories\GenreFactory> */
    use HasFactory;

    protected $fillable = ['name', 'movie_db_id'];

    // region Methods

    /**
     * @throws \Exception
     */
    public static function fetchGenres(): void
    {
        $data = TmdbClient::getInstance()->fetchGenres();

        if (! $genres = $data['genres'] ?? null) {
            throw new \Exception('Não foi possível carregar os gêneros');
        }

        foreach ($genres as $genre) {
            static::create([
                'movie_db_id' => $genre['id'],
                'name' => $genre['name'],
            ]);
        }
    }
    // endregion
}
