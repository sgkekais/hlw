<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRescheduledByToFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            // add a rescheduled_by column to identify the team that cancelled the match
            $table->integer('rescheduled_by_club')->nullable()->unsigned()->after('rescheduled_to_fixtures_id');

            // foreign key relationship
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
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropColumn('rescheduled_by_club');
        });
    }
}
