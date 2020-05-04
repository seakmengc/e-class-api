<?php

namespace Tests\Feature\Traits;

use App\Models\User;
use Spatie\Permission\Models\Role;

trait PrepareForFeatureTesting
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        Role::create(['name' => 'Super Admin']);

        $this->user->assignRole('Super Admin');
        $this->actingAs($this->user, 'api');
    }
}
