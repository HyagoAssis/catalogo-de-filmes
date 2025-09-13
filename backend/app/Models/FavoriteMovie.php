<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavoriteMovie extends BaseModel
{
    use HasFactory;

    protected $table = 'favorite_movies';

    protected $fillable = [
        'name', 'movie_db_id', 'user_id',
    ];

    // region Relations
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // endregion
}
