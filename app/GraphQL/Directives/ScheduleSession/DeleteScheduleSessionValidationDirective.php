<?php

namespace App\GraphQL\Directives\ScheduleSession;


use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class DeleteScheduleSessionValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
    return [
      'id' => 'required'
    ];
  }
}
