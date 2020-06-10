<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Exam::class, function (Faker $faker) {
    return [
        'class_category_id' => factory(App\Models\ClassCategory::class),
        'name' => $faker->name,
        'possible' => $faker->numberBetween(1, 100),
        'description' => $faker->text,
        'qa' => $faker->word,
        'attempts' => $faker->numberBetween(1, 10),
        'publishes_at' => $faker->dateTime(),
        'due_at' => $faker->dateTime(),
    ];
});
