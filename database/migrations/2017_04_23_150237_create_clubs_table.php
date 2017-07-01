<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            // Keep most things nullable here, since clubs provide different amounts of details
            $table->increments('id');
            $table->string('name');
            $table->string('name_short')->nullable();
            $table->string('name_code')->nullable();        // code for club, e.g. SWB for SW Bilk
            $table->text('logo_url')->nullable();           // URL to logo on file server
            $table->date('founded')->nullable();
            $table->date('league_entry')->nullable();       // entry into HLW
            $table->date('league_exit')->nullable();        // exit from HLW
            $table->string('colours_club')->nullable();     // primary colours of club, e.g. for bg-color on club page
            $table->string('colours_kit')->nullable();
            $table->text('website')->nullable();
            $table->text('facebook')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_real_club')->default('0');
            $table->boolean('published')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}
