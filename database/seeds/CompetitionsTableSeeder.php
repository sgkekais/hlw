<?php

use Illuminate\Database\Seeder;

class CompetitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Competition::class, 10)->create()->each(function ($c){
            $c->divisions()->save(factory(App\Division::class)->make());
        });
    }
}
