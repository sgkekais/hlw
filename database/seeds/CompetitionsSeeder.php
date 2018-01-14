<?php

use Illuminate\Database\Seeder;

class CompetitionsSeeder extends Seeder
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
        DB::table('competitions')->insert([
            'id'            => 1,
            'name'          => 'Hobbyliga-West',
            'name_short'    => 'HLW',
            'type'          => 'league',
            'published'     => 1,
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 2,
            'name'          => 'Hobbyliga-West Pokal',
            'name_short'    => 'P',
            'type'          => 'knockout',
            'published'     => 1,
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 3,
            'name'          => 'Altherren-Liga',
            'name_short'    => 'AHL',
            'type'          => 'league',
            'published'     => 1,
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ]);
    }
}
