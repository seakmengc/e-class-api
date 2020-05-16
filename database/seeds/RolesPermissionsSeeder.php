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
        $defaultRoles = ['Super Admin', 'Admin', 'Teacher', 'Student'];

        $ownActions = [
            'View Own',
            'Create Own',
            'Update Own',
            'Delete Own'
        ];
        $anyActions = [
            'View Any',
            'Create Any',
            'Update Any',
            'Delete Any'
        ];

        $defaultPG = [
            'User' => [...$anyActions, ...$ownActions],
        ];

        DB::beginTransaction();

        array_walk($defaultRoles, fn ($role) => Role::create([
            'name' => $role
        ]));

        foreach ($defaultPG as $pgName => $actions) {
            $pg = PermissionGroup::create([
                'name' => $pgName,
                'guard_name' => 'api'
            ]);

            array_walk($actions, fn ($permName) => $pg->permissions()->create([
                'name' => $permName,
            ]));
        }

        DB::commit();
    }
}
