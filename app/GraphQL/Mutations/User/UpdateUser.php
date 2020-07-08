<?php

namespace App\GraphQL\Mutations\User;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class UpdateUser
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        DB::beginTransaction();

        $user = User::findOrFail($args['id']);
        $user->update($args);
        $user->identity->update($args);
        $user->syncRoles($args['role_id']);

        DB::commit();

        return $user;
    }
}
