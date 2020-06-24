<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\StudentAbsence::class, function (Faker $faker) {
    return [
        'student_id' => factory(App\Models\User::class),
        'has_permission' => $faker->boolean,
        'class_attendance_id' => $faker->randomNumber(),
        'reason' => $faker->text,
    ];
});
