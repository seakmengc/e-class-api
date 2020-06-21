<?php

namespace App\GraphQL\Directives\StudentExam;

use App\Models\StudentExam;
use App\Rules\ValidPoints;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class GradeStudentExamValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        $exam = StudentExam::findOrFail($this->args['id'])->exam;
        return [
            'id' => 'required',
            'answer' => 'required|array',
            'answer.*.id' => ['required', 'distinct'],
            'answer.*.points' => ['required', 'numeric', 'min:0', new ValidPoints($this->args, $exam->qa)],
        ];
    }
}
