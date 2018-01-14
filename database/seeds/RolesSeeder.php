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
            'id'            => 1,
            'name'          => 'super_admin',
            'guard_name'    => 'web',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 2,
            'name'          => 'admin',
            'guard_name'    => 'web',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 3,
            'name'          => 'visitor',
            'guard_name'    => 'web',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ]);
    }
}
