<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    $thread = Thread::create([
        'subject' => $faker->word
    ]);

    $users = factory(User::class, rand(1, 4))->create();

    return [
        'thread_id' => $thread->id,
        'user_id' => $users[rand(0, 3)]->id,
        'body' => $faker->sentence
    ];
});
