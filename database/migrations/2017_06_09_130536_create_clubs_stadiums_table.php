<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsStadiumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs_stadiums', function (Blueprint $table) {
            $table->integer('club_id')->unsigned();
            $table->integer('stadium_id')->unsigned();
            $table->string('regular_home_day')->nullable();     // only for info on club page, fixture date and time always count for fixture
            $table->time('regular_home_time')->nullable();    // only for info on club page, fixture date and time always count for fixture
            $table->text('note')->nullable();
            $table->boolean('is_regular_stadium')->default('1');    // is this the "main" stadium of the club?

            $table->timestamps();

            // foreign key constraints
            $table->foreign('club_id')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('stadium_id')
                ->references('id')->on('stadiums')
                ->onUpdate('cascade')->onDelete('cascade');
            // combine foreign keys to composite primary key
            $table->primary(['club_id','stadium_id'], 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs_stadiums');
    }
}
