<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixturesRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures_referees', function (Blueprint $table) {
            $table->integer('fixture_id')->unsigned();
            $table->integer('referee_id')->unsigned();
            $table->text('note')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('fixture_id')
                ->references('id')->on('fixtures')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('referee_id')
                ->references('id')->on('referees')
                ->onUpdate('cascade')->onDelete('cascade');
            // composite key
            $table->primary(['fixture_id','referee_id'], 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures_referees');
    }
}
