<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('division_id')->unsigned();
            $table->integer('year_begin')->unsigned();
            $table->integer('year_end')->unsigned();
            $table->integer('season_nr')->unsigned()->nullable();
            $table->integer('champion')->unsigned()->nullable();    // season champion
            $table->string('ranks_champion')->nullable();
            $table->string('ranks_promotion')->nullable();
            $table->string('ranks_relegation')->nullable();
            $table->string('playoff_champion')->nullable();         // championship-playoff -> serialize ranks 1,2,3,4,etc.
            $table->string('playoff_cup')->nullable();              // cup-playoff
            $table->string('playoff_relegation')->nullable();       // relegation-playoff
            $table->text('rules')->nullable();  // describe relegation / promotion rules etc., display below table
            $table->text('note')->nullable();
            $table->boolean('published')->default('0');

            $table->timestamps();

            // foreign keys
            $table->foreign('division_id')
                ->references('id')->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('champion')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasons');
    }
}
