<?php

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateUserValidationDirective extends ValidationDirective
{
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'uuid' => 'max:255|unique:users',
            'contact_number' => 'max:255',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|in:male,female,others',
            'photo' => 'image|max:5120'
        ];
    }
}
