<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Forum::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->text,
        'answer_id' => null,
    ];
});
