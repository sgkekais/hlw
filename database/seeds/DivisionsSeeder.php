<?php

use Illuminate\Database\Seeder;

class DivisionsSeeder extends Seeder
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
        DB::table('divisions')->insert([
            0 => [
                'id'            => 1,
                'competition_id'=> 1,
                'name'          => '1. Liga',
                'hierarchy_level' => 1,
                'published'     => 1,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            1 => [
                'id'            => 2,
                'competition_id'=> 1,
                'name'          => '2. liga',
                'hierarchy_level' => 2,
                'published'     => 1,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            2 => [
                'id'            => 3,
                'competition_id'=> 2,
                'name'          => 'Pokal',
                'hierarchy_level' => 1,
                'published'     => 1,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ],
            3 => [
                'id'            => 4,
                'competition_id'=> 3,
                'name'          => 'Altherren-Liga',
                'hierarchy_level' => 1,
                'published'     => 1,
                'created_at'    => $timestamp,
                'updated_at'    => $timestamp
            ]
        ]);
    }
}
