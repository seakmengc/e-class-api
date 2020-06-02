<?php

namespace App\GraphQL\Directives\Schedule;


use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class DeleteScheduleValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'id' => 'required'
    ];
  }
}
