<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassportsColumnToClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clubs', function (Blueprint $table) {
            //
            $table->text('passports_url')->nullable()->after('cover_url');
            $table->dateTime('passports_timestamp')->nullable()->after('passports_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
            //
            $table->dropColumn('passports_url');
            $table->dropColumn('passports_timestamp');
        });
    }
}
