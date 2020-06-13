<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Identity::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(['male', 'female', 'others']),
        'contact_number' => $faker->numerify("0########"),
    ];
});
