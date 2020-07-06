<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classes;
use Faker\Generator as Faker;

$factory->define(App\Models\Classes::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
        'code' => $faker->numerify('CS###'),
        'teacher_id' => factory(App\Models\User::class)->create([
            'username' => $faker->unique()->numerify('teacher##')
        ]),
    ];
});
