<?php

namespace App\GraphQL\Directives;

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
            'contact_number' => 'max:255',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'gender' => 'in:male,female,others',
            'photo' => 'image|max:5120'
        ];
    }
}
