<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieRaterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_rater', function (Blueprint $table) {
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('rater_id');

            $table->primary(['movie_id', 'rater_id']);
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('rater_id')->references('id')->on('raters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_rater');
    }
}
