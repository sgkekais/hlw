<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixture_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->string('score')->nullable();        // result, e.g. 1:2

            $table->timestamps();

            // foreign keys
            $table->foreign('fixture_id')
                ->references('id')->on('fixtures')
                ->onUpdate('cascade')->onDelete('cascade');
            /*$table->foreign('player_id')
                ->references('id')->on('players')
                ->onUpdate('cascade')->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
