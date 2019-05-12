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
    $programs = [
        'DA', 'MA', 'NA', 'PCT', 'PH', 'HS-DA', 'HS-MA', 'HS-PCT',
        'MAA', 'MBC', 'MOBS', 'HHS-A', 'HIT', 'HCM', 'HS-HTS', 'HS-MAA', 
        'MBC-A', 'HS-MOBS', 'HS-PHT',
    ];
    $leadvendors = [
        'google', 'bing', 'levi', 'maci'
    ];
    $program = array_rand($programs);
    $program = $programs[$program];
    $vendor = array_rand($leadvendors);
    $vendor = $leadvendors[$vendor];
    return [
        'first_name'     => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'    => $faker->email,
        'phone' => $faker->phoneNumber,
        'additional_fields' => json_encode([
            'program_code' => $program,
            'vendor' => $vendor
        ]),
        'created_at' => $faker->dateTimeBetween('-6 months', '+6 months')
    ];
});