<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends BaseModel
{
    protected $table = 'favorite_movies';

    protected $fillable = [
        'name', 'movie_db_id', 'user_id',
    ];


    //region Relations
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //endregion
}
