<?php

namespace App\GraphQL\Directives\User;

use App\Rules\Composite\User\UuidRule;
use App\Rules\Composite\User\EmailRule;
use App\Rules\Composite\User\UsernameRule;
use App\Rules\Composite\User\PasswordRule;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateUserCredentialsValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        $userId = (int) $this->args['user_id'];

        return [
            'user_id' => 'required',
            'username' => new UsernameRule($userId),
            'email' => new EmailRule($userId),
            'uuid' => new UuidRule($userId),
            'password' => ['confirmed', new PasswordRule()],
        ];
    }
}
