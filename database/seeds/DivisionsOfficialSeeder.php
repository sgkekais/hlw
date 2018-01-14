<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsOfficialSeeder extends Seeder
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
        DB::table('divisions_official')->insert([
            'id'            => 1,
            'name'          => 'Kreisliga A',
            'name_short'    => 'Kl. A',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 2,
            'name'          => 'Kreisliga B',
            'name_short'    => 'Kl. B',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 3,
            'name'          => 'Kreisliga C',
            'name_short'    => 'Kl. C',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 4,
            'name'          => 'Kreisliga D',
            'name_short'    => 'Kl. D',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 5,
            'name'          => 'Trainer',
            'name_short'    => 'Tr.',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 6,
            'name'          => 'Passiv',
            'name_short'    => 'P',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ], [
            'id'            => 7,
            'name'          => 'A-Jugend',
            'name_short'    => 'A-Jun.',
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp
        ]);
    }
}
