<?php

namespace App\GraphQL\Directives\ScheduleSession;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateScheduleSessionValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'id' => 'required',
      'start_date' => 'required|digits:4',
      'end_date' => 'required|digits:4',
    ];
  }
}
