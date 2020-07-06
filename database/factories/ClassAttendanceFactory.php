<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ClassAttendance::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
    ];
});
