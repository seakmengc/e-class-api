<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $this->call(RolesPermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        Auth::guard('api')->setUser(User::first());
        $this->call(ClassSeeder::class);

        DB::commit();
    }
}
