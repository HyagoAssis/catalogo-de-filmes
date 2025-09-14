<?php

namespace App\Http\Requests\FavoriteMovie;

use App\Rules\FavoriteMovieUnique;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name;
 * @property-read int $movie_db_id;
 * @property-read string $overview;
 * @property-read string $poster_path;
 * @property-read Carbon $release_date;
 */
class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'movie_db_id' => [
                'integer',
                'required',
                new FavoriteMovieUnique,
            ],
            'overview' => 'string',
            'poster_path' => 'string',
            'release_date' => 'date',
        ];
    }
}
