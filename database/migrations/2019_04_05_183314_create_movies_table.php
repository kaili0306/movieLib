<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->increments('id');
            $table->string('title')->indexed()->nullable();
            $table->integer('duration')->nullable();
            $table->string('summary')->indexed()->nullable();
            $table->string('genre')->indexed()->nullable();
            $table->string('director')->indexed()->nullable();
            $table->string('cast')->indexed()->nullable();
            $table->date('datePublished')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
