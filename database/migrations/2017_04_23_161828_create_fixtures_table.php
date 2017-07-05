<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('matchweek_id')->unsigned();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('stadium_id')->unsigned()->nullable();     // foreign key relationship to stadium_id
            $table->integer('club_id_home')->unsigned()->nullable();   // foreign key relationship to club_id
            $table->integer('club_id_away')->unsigned()->nullable();   // foreign key relationship to club_id
            $table->integer('goals_home')->unsigned()->nullable();
            $table->integer('goals_away')->unsigned()->nullable();
            $table->integer('goals_home_11m')->unsigned()->nullable();
            $table->integer('goals_away_11m')->unsigned()->nullable();
            $table->integer('goals_home_rated')->unsigned()->nullable();    // if match result has been rated (due to ruling or other)
            $table->integer('goals_away_rated')->unsigned()->nullable();    // if match result has been rated (due to ruling or other)
            $table->text('note')->nullable();
            $table->boolean('cancelled')->default('0');    // complete cancellation, default: not cancelled
            $table->boolean('published')->default('0');    // publish on website?, default: not listed/published
            $table->integer('rescheduled_from_fixture_id')->unsigned()->nullable();    // match has been rescheduled from fixture_id
            // $table->integer('rescheduled_to_fixture_id')->unsigned()->nullable();      // match has been rescheduled to fixture_id
            // add a rescheduled_by column to identify the team that cancelled the match
            $table->integer('rescheduled_by_club')->nullable()->unsigned();

            $table->timestamps();

            // foreign keys
            $table->foreign('matchweek_id')
                ->references('id')->on('matchweeks')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('stadium_id')
                ->references('id')->on('stadiums')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('club_id_home')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('club_id_away')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('rescheduled_from_fixture_id')
                ->references('id')->on('fixtures')
                ->onUpdate('cascade')->onDelete('set null');
            /*$table->foreign('rescheduled_to_fixtures_id')
                ->references('id')->on('fixtures')
                ->onUpdate('cascade')->onDelete('set null');*/
            $table->foreign('rescheduled_by_club')
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
        Schema::dropIfExists('fixtures');
    }
}
