<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ClassContent::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'class_id' => factory(App\Models\Classes::class),
    ];
});
