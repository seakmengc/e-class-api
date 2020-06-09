<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ScheduleSession;
use Faker\Generator as Faker;

$factory->define(ScheduleSession::class, function (Faker $faker) {
    return [
        //
        'schedule_id' => factory(App\Models\Schedule::class),
        'start_time' => $faker->dateTime()->format('H:i:s'),
        'end_time' => $faker->dateTime()->format('H:i:s')
    ];
});
