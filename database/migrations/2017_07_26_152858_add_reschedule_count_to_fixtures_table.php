<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRescheduleCountToFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->boolean('reschedule_count')->default('0')->after('reschedule_reason');
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
            $table->dropColumn('reschedule_count');
        });
    }
}
