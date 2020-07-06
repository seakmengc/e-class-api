<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ClassContent::class, function (Faker $faker) {
    return [
        'name' => $faker->words(5, true),
        'description' => $faker->text,
    ];
});
