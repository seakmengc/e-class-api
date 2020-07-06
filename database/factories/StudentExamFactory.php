<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\StudentExam::class, function (Faker $faker) {
    return [
        'answer' => $faker->word,
        'point' => $faker->randomFloat(),
    ];
});
