<?php

namespace App\GraphQL\Directives\StudentExam;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateStudentExamValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            'exam.connect' => ['bail', 'required', 'integer', 'exists:exams,id'],
            'answers.*.id' => ['required', 'distinct'],
            'answers.*.answers' => ['array'],
        ];
    }
}
