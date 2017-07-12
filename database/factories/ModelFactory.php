<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/**
 * Competition
 */
$factory->define(App\Competition::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'type' => $faker->randomElement(['league', 'knockout', 'tournament']),
        'published' => $faker->numberBetween(0,1)
    ];
});
/**
 * Division
 */
$factory->define(App\Division::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'hierarchy_level' => $faker->numberBetween(1,5),
        'published' =>  $faker->numberBetween(0,1)
    ];
});