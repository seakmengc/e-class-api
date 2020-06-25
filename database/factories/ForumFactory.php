<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Forum::class, function (Faker $faker) {
    return [
        'class_content_id' => factory(App\Models\ClassContent::class),
        'title' => $faker->word,
        'description' => $faker->text,
        'answer_id' => null,
    ];
});
