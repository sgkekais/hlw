<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchweeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchweeks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->unsigned();
            $table->integer('number_consecutive')->nullable()->unsigned();  // consecutive number of the matchweek, e.g. matchweek 12
            $table->string('name')->nullable();
            $table->date('begin')->nullable();
            $table->date('end')->nullable();
            $table->boolean('published')->default('0');

            $table->timestamps();

            // foreign keys
            $table->foreign('season_id')
                ->references('id')->on('seasons')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchweeks');
    }
}
