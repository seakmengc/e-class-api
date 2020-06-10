<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\StudentExam::class, function (Faker $faker) {
    return [
        'student_id' => factory(App\Models\User::class),
        'exam_id' => factory(App\Models\Exam::class),
        'answer' => $faker->word,
        'point' => $faker->randomFloat(),
    ];
});
