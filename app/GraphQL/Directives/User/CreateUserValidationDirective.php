<?php

namespace App\GraphQL\Directives\User;

use App\Rules\Composite\User\EmailRule;
use App\Rules\Composite\User\ContactNumberRule;
use App\Rules\Composite\User\FirstNameRule;
use App\Rules\Composite\User\GenderRule;
use App\Rules\Composite\User\LastNameRule;
use App\Rules\Composite\User\PasswordRule;
use App\Rules\Composite\User\PhotoRule;
use App\Rules\Composite\User\UsernameRule;
use App\Rules\Composite\User\UuidRule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateUserValidationDirective extends ValidationDirective
{
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'username' => new UsernameRule(),
            'email' => new EmailRule(),
            'uuid' => new UuidRule(),
            'password' => [new PasswordRule()],
            'role_id' => 'required|bail|integer|exists:roles,id',
            'first_name' => new FirstNameRule(),
            'last_name' => new LastNameRule(),
            'gender' => new GenderRule(),
            'contact_number' => new ContactNumberRule(),
            'photo' => new PhotoRule()
        ];
    }
}
