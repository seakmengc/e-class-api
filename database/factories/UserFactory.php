<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->numerify("0########"),
        'password' => 'password', // password
    ];
});
