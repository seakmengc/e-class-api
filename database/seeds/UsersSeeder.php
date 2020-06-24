<?php

use App\Models\Identity;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'username' => 'admin'
        ]);

        factory(Identity::class)->create(['user_id' => $user->id]);

        $user->assignRole('admin');
    }
}
