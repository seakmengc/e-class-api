<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'subject' => $faker->word
    ];
});
