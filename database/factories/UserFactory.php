<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'username' => $faker->unique()->numerify('user###'),
        'email' => $faker->unique()->safeEmail,
        'password' => 'password', // password
    ];
});
