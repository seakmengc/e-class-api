<?php

namespace App\GraphQL\Directives\Schedule;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateScheduleValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'id' => 'required',
      'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
    ];
  }
}
