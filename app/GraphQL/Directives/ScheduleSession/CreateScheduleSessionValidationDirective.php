<?php

namespace App\GraphQL\Directives\ScheduleSession;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateScheduleSessionValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'start_date' => 'required|digits:4',
      'end_date' => 'required|digits:4',
    ];
  }
}
