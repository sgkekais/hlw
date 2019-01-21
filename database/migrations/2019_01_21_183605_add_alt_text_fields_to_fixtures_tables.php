<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAltTextFieldsToFixturesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->string('club_id_home_alt_text')->nullable()->after('club_id_home');
            $table->string('club_id_away_alt_text')->nullable()->after('club_id_away');
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
            $table->dropColumn('club_id_home_alt_text');
            $table->dropColumn('club_id_away_alt_text');
        });
    }
}
