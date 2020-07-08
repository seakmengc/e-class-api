<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Models\ScheduleSession::class, function (Faker $faker) {
    $startTime = Carbon::parse($faker->unique()->dateTime);
    return [
        'start_time' => $startTime->toTimeString('minute'),
        'end_time' => $startTime->addMinutes(50)->toTimeString('minute'),
    ];
});
