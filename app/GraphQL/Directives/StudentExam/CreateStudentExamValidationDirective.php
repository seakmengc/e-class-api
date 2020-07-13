<?php

namespace App\GraphQL\Directives\StudentExam;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateStudentExamValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            'exam_id' => ['bail', 'required', 'integer', 'exists:exams,id'],
            'answer.*.id' => ['required', 'distinct'],
            'answer.*.answers' => ['array'],
            'answer.*.file' => ['file'],
        ];
    }
}
