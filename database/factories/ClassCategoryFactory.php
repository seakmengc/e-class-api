<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ClassCategory::class, function (Faker $faker) {
    return [
        'class_id' => factory(App\Models\Classes::class),
        'name' => $faker->name,
        'weight' => $faker->randomNumber(2),
    ];
});
