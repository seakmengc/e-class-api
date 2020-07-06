<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Exam::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'possible' => $faker->numberBetween(1, 100),
        'description' => $faker->text,
        'qa' => [
            [
                'id' => 1,
                'question' => "What is Algorithm?",
                'type' => 'qcm',
                'answers' => ["abc", "bcd", "efg", "hig"],
                'possibles' => ["abc", "bcd"],
                'points' => 5,
            ],
            [
                'id' => 2,
                'question' => "What is Algorithm?",
                'type' => 'essay',
                'points' => 10,
            ],
            [
                'id' => 3,
                'question' => "Do this excercise.",
                'type' => 'upload',
                'points' => 5,
            ]
        ],
        'attempts' => $faker->numberBetween(1, 10),
        'publishes_at' => $faker->dateTime(),
        'due_at' => $faker->dateTime(),
    ];
});
