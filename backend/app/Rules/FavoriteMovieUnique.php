<?php

namespace App\Rules;

use App\Models\FavoriteMovie;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FavoriteMovieUnique implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @throws ValidationException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userId = auth()->id();

        $exists = FavoriteMovie::query()
            ->where('user_id', $userId)
            ->where('movie_db_id', $value)
            ->exists();

        if ($exists) {
            $fail('Filme já favoritado pelo usuário');
        }
    }
}
