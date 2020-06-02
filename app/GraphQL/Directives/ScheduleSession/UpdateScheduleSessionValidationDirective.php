<?php

namespace App\GraphQL\Directives\ScheduleSession;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateScheduleSessionValidationDirective extends ValidationDirective
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
