<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\PermissionGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'guard_name' => 'api',
    ];
});
