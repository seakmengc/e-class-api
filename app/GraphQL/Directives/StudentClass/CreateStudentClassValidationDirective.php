<?php

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateStudentClassValidationDirective extends ValidationDirective
{
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required',
            'class_id' => 'required',
        ];
    }
}
