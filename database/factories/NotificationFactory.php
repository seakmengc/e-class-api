<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Notification::class, function (Faker $faker) {
    return [
        'type' => $faker->word,
        'notifiable_type' => $faker->word,
        'notifiable_id' => $faker->randomNumber(),
        'data' => $faker->text,
        'read_at' => $faker->dateTime(),
    ];
});
