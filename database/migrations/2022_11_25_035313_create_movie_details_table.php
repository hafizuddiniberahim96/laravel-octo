<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movies_id');
            $table->unsignedBigInteger('rating_id');
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('language_id');
            $table->timestamps();

            $table->index(['movies_id', 'rating_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_details');
    }
};
