<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorite_movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('movie_db_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('overview', '1000')->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->timestamps();

            $table->unique(['movie_db_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_movies');
    }
};
