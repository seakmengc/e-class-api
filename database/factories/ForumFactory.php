<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Forum::class, function (Faker $faker) {
    return [
        'class_content_id' => factory(App\Models\ClassContent::class),
        'title' => $faker->word,
        'description' => $faker->text,
        'author_id' => factory(App\Models\User::class),
        'answer_id' => factory(App\Models\Comment::class),
    ];
});
