<?php

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Database\Seeder;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num_msgs = (int) $this->command->ask('Enter number of messages: ', 10);
        $num_users = (int) $this->command->ask('Enter number of users: ', 2);

        DB::beginTransaction();
        $thread = factory(Thread::class)->create();

        $users = factory(User::class, $num_users)->create();

        $users->each(fn ($user) => $thread->addParticipant($user->id));

        factory(Message::class, (int) $num_msgs)->create([
            'thread_id' => $thread->id,
            'user_id' => $users[rand(0, $num_users - 1)]->id
        ]);

        DB::commit();
    }
}
