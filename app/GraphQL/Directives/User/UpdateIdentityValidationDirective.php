<?php

namespace App\GraphQL\Directives\User;

use App\Rules\Composite\User\PhotoRule;
use App\Rules\Composite\User\GenderRule;
use App\Rules\Composite\User\LastNameRule;
use App\Rules\Composite\User\FirstNameRule;
use App\Rules\Composite\User\ContactNumberRule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateIdentityValidationDirective extends ValidationDirective
{
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'first_name' => new FirstNameRule(),
            'last_name' => new LastNameRule(),
            'gender' => new GenderRule(),
            'contact_number' => new ContactNumberRule(),
            'photo' => new PhotoRule()
        ];
    }
}
