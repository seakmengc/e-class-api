<?php

namespace App\GraphQL\Directives\User;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use App\Rules\Composite\User\UuidRule;
use App\Rules\Composite\User\UsernameRule;
use App\Rules\Composite\User\PhotoRule;
use App\Rules\Composite\User\PasswordRule;
use App\Rules\Composite\User\LastNameRule;
use App\Rules\Composite\User\GenderRule;
use App\Rules\Composite\User\FirstNameRule;
use App\Rules\Composite\User\EmailRule;
use App\Rules\Composite\User\ContactNumberRule;

class UpdateUserValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        $userId = (int) $this->args['id'];

        return [
            'username' => new UsernameRule($userId),
            'uuid' => new UuidRule($userId),
            'email' => new EmailRule($userId),
            'password' => new PasswordRule(),
            'role_id' => 'required|bail|integer|exists:roles,id',
            'first_name' => new FirstNameRule(),
            'last_name' => new LastNameRule(),
            'gender' => new GenderRule(),
            'contact_number' => new ContactNumberRule(),
            'photo' => new PhotoRule()
        ];
    }
}
