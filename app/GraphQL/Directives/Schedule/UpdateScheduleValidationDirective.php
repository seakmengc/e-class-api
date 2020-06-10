<?php

namespace App\GraphQL\Directives\Schedule;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateScheduleValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'id' => 'required',
      'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
    ];
  }
}
