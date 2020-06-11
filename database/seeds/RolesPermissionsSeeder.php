<?php

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultRoles = ['admin', 'teacher', 'student', 'user'];

        DB::beginTransaction();

        array_walk($defaultRoles, fn ($role) => Role::create([
            'name' => $role
        ]));

        DB::commit();
    }
}
