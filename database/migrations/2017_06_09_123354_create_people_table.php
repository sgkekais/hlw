<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('photo')->nullable();        // passport photograph
            $table->boolean('photo_public')->default('0');
            $table->integer('registered_at_club')->unsigned()->nullable();  // Official (non HLW) club the person is currently playing for

            $table->timestamps();

            // foreign keys
            $table->foreign('registered_at_club')
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
        Schema::dropIfExists('people');
    }
}
