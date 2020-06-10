<?php

namespace App\GraphQL\Directives\StudentAbsence;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateStudentAbsenceValidationDirective extends ValidationDirective
{
  public function rules(): array
  {
    return [
      'has_permission' => 'required',
      'reason' => 'required|min:4',
      'class_attendance_id' => 'required'
    ];
  }
}
