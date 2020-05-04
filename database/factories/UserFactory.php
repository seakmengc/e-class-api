<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'password' => bcrypt('password'),
    ];
});
