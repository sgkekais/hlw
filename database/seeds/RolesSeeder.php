<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();
        // insert competitions
        DB::table('roles')->insert([
            0 => [
                'id'            => 1,
                'name'          => 'super_admin',
                'display_name'  => 'Super Admin',
                'guard_name'    => 'web',
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            1 => [
                'id'            => 2,
                'name'          => 'admin',
                'display_name'  => 'Admin',
                'guard_name'    => 'web',
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            2 => [
                'id'            => 3,
                'name'          => 'member',
                'display_name'  => 'Mitglied',
                'guard_name'    => 'web',
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            3 => [
                'id'            => 4,
                'name'          => 'club_contact',
                'display_name'  => 'Ansprechpartner',
                'guard_name'    => 'web',
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ]
        ]);
    }
}
