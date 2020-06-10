<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ScheduleSession::class, function (Faker $faker) {
    return [
        'schedule_id' => factory(App\Models\Schedule::class),
        'start_time' => $faker->word,
        'end_time' => $faker->word,
    ];
});
