<?php

namespace App\GraphQL\Directives\Exams;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateExamValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            // 'class_category_id' => ['bail', 'required', 'integer', 'exists:class_categories,id'],
            'name' => ['bail', 'required', 'string', 'max:255'],
            'possible' => ['bail', 'required'],
            'description' => ['bail', 'string'],
            'qa' => ['bail', 'json'],
            'attempt' => ['bail', 'required', 'integer'],
            'publishes_at' => ['bail', 'date'],
            'due_at' => ['bail', 'date'],
        ];
    }
}
