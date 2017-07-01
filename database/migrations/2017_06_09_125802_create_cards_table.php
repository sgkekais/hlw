<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixture_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->boolean('red')->default('0');       // if false, then yellow-red card
            $table->integer('ban_matches')->unsigned()->nullable(); // number of matches banned
            $table->boolean('ban_season')->default('0');    // banned for this season?
            $table->boolean('ban_lifetime')->default('0');  // banned for life?
            $table->text('note')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('fixture_id')
                ->references('id')->on('fixtures')
                ->onUpdate('cascade')->onDelete('cascade');
            /*$table->foreign('person_id')
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
        Schema::dropIfExists('cards');
    }
}
