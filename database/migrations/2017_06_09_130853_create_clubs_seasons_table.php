<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs_seasons', function (Blueprint $table) {
            $table->integer('club_id')->unsigned();
            $table->integer('season_id')->unsigned();
            $table->integer('rank')->nullable()->unsigned();    // rank at the end of the season
            $table->integer('deduction_points')->nullable();    // point penalty
            $table->integer('deduction_goals')->nullable();     // goal penalty
            $table->date('withdrawal')->nullable();     // date when club left mid-season
            $table->text('note')->nullable();           // note for withdrawal or penalty

            $table->timestamps();

            // foreign keys
            $table->foreign('club_id')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('season_id')
                ->references('id')->on('seasons')
                ->onUpdate('cascade')->onDelete('cascade');
            // combine foreign keys to composite primary key
            $table->primary(['club_id','season_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs_seasons');
    }
}
