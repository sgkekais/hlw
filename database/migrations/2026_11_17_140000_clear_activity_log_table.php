<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The activity log starts empty with the Laravel 13 version of the site.
 * The old entries (since 2018, mostly changes of people and players) are
 * only kept in the database backup taken before the switch.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::connection(config('activitylog.database_connection'))
            ->table(config('activitylog.table_name'))
            ->truncate();
    }

    public function down(): void
    {
        // the deleted entries can only be restored from the backup
    }
};
