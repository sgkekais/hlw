<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_clubs', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('club_id')->unsigned();
            $table->timestamps();

            // foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('club_id')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
            // combine foreign keys to composite primary key
            $table->primary(['user_id','club_id'],'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_clubs');
    }
}
