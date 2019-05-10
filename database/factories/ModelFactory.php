<?php

use Illuminate\Support\Facades\Hash;

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'     => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'    => $faker->unique()->email,
        'password' => Hash::make('test'),
    ];
});

$factory->define(App\FormEntry::class, function (Faker\Generator $faker) {
    return [
        'first_name'     => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'    => $faker->email,
        'phone' => $faker->phoneNumber,
        'additional_fields' => json_encode([
            'program_code' => $faker->text,
            'date' => $faker->date
        ]),
        'created_at' => $faker->dateTimeBetween('-6 months', '+6 months')
    ];
});