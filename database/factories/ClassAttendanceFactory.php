<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ClassAttendance::class, function (Faker $faker) {
    return [
        'schedule_sessions_id' => factory(App\Models\ScheduleSession::class),
        'class_id' => factory(App\Models\Classes::class),
        'date' => $faker->date(),
    ];
});
