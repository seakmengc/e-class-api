<?php

namespace App\GraphQL\Directives\Exam;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateExamValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            'classCategory.connect' => ['bail', 'required', 'integer', 'exists:class_categories,id'],
            'name' => ['bail', 'required', 'string', 'max:255'],
            'possible' => ['bail', 'required'],
            'description' => ['bail', 'string'],
            'qa' => ['bail', 'array'],
            'attempts' => ['bail', 'required', 'integer'],
            'publishes_at' => ['bail', 'date', 'before_or_equal:now'],
            'due_at' => ['bail', 'date', 'before_or_equal:now'],
        ];
    }
}