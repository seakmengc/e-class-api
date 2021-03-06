<?php

namespace App\GraphQL\Directives\ClassAttendance;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassAttendanceValidationDirective extends ValidationDirective
{
  public function rules(): array
  {
    return [
      'schedule_session_id' => 'required',
      'class_id' => 'required',
      'date' => 'required'
    ];
  }
}
