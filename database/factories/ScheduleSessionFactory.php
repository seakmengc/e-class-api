<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ScheduleSession::class, function (Faker $faker) {
    return [
        'schedule_id' => factory(App\Models\Schedule::class),
        'start_time' => $startTime = $faker->unique()->numberBetween(0, 2300),
        'end_time' => $startTime + 50,
    ];
});
