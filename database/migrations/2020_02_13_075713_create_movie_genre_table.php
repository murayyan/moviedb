<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_genre', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('genre_id');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_genre');
    }
}
