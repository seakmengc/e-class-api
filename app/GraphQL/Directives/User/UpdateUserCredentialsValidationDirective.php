<?php

namespace App\GraphQL\Directives\User;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateUserCredentialsValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'uuid' => 'max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
