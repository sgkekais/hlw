<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('club_id')->unsigned();
            $table->date('sign_on');                    // signed with club
            $table->date('sign_off')->nullable();       // left club
            $table->string('number')->nullable();       // jersey / team number, string because there can be crazy stuff in sunday / hobby leagues
            $table->integer('position_id')->unsigned()->nullable();    // relation with position, enables only one position

            $table->timestamps();

            // foreign key constraints
            $table->foreign('person_id')
                ->references('id')->on('people')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('club_id')
                ->references('id')->on('clubs')
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
        Schema::dropIfExists('players');
    }
}
