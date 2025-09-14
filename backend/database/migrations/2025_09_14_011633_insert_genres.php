<?php

use App\Models\Genre;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        Genre::truncate();
        Genre::fetchGenres();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
