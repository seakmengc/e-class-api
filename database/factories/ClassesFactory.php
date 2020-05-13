<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classes;
use Faker\Generator as Faker;

$factory->define(App\Models\Classes::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->userName,
        'code' => $faker->postcode,
        'teacher_id' => factory(App\Models\User::class),
    ];
});
