<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\StudentsAbsences::class, function (Faker $faker) {
    return [
        'student_id' => factory(App\Models\User::class),
    ];
});
