<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->integer('hierarchy_level')->nullable()->unsigned(); // "ranking" of contacts
            $table->string('mail')->nullable();
            $table->string('mobile')->nullable();

            $table->timestamps();

            // foreign key constraints
            $table->foreign('club_id')
                ->references('id')->on('clubs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('person_id')
                ->references('id')->on('people')
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
        Schema::dropIfExists('contacts');
    }
}
