<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Removes what the public accounts left behind: the forum, the favorite clubs,
 * password resets and all users without the role admin or super_admin
 * (released by the board in November 2026). Only the database backup taken
 * before the switch keeps the deleted data.
 */
return new class extends Migration
{
    const ADMIN_ROLES = ['admin', 'super_admin'];

    public function up(): void
    {
        // tables of the forum, favorites and password resets, in foreign key order
        foreach (['chatter_user_discussion', 'chatter_post', 'chatter_discussion', 'chatter_categories', 'users_clubs', 'password_resets'] as $table) {
            Schema::dropIfExists($table);
        }

        $roles = config('permission.table_names.model_has_roles');
        $permissions = config('permission.table_names.model_has_permissions');
        $userType = HLW\User::class;

        $admins = DB::table($roles)
            ->join('roles', 'roles.id', '=', $roles.'.role_id')
            ->where($roles.'.model_type', $userType)
            ->whereIn('roles.name', self::ADMIN_ROLES)
            ->pluck($roles.'.model_id')
            ->unique();

        // without admins the site could not be managed anymore
        if ($admins->isEmpty()) {
            throw new RuntimeException('No user with the role admin or super_admin found, no users deleted.');
        }

        DB::table('users')->whereNotIn('id', $admins)->delete();

        // role and permission assignments of deleted or long gone users
        DB::table($roles)->where('model_type', $userType)->whereNotIn('model_id', $admins)->delete();
        DB::table($permissions)->where('model_type', $userType)->whereNotIn('model_id', $admins)->delete();
    }

    public function down(): void
    {
        // the deleted users and tables can only be restored from the backup
    }
};
