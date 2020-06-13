<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Exam::class, function (Faker $faker) {
    return [
        'class_category_id' => ($classCat = factory(App\Models\ClassCategory::class)->create())->id,
        'class_id' => $classCat->class_id,
        'name' => $faker->name,
        'possible' => $faker->numberBetween(1, 100),
        'description' => $faker->text,
        'qa' => $faker->word,
        'attempts' => $faker->numberBetween(1, 10),
        'publishes_at' => $faker->dateTime(),
        'due_at' => $faker->dateTime(),
    ];
});
