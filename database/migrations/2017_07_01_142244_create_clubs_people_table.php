<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs_people', function (Blueprint $table) {
            $table->integer('club_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->date('sign_on');                    // signed with club
            $table->date('sign_off')->nullable();       // left club
            $table->string('number')->nullable();       // jersey / team number, string because there can be crazy stuff in sunday / hobby leagues
            $table->integer('position_id')->unsigned()->nullable();    // relation with position, enables only one position

            $table->timestamps();

            // foreign keys
            $table->foreign('club_id')
                ->references('id')->on('clubs');
            $table->foreign('person_id')
                ->references('id')->on('people');
            $table->foreign('position_id')
                ->references('id')->on('positions');
            // combine foreign keys to composite primary key
            $table->primary(['club_id','person_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs_people');
    }
}
