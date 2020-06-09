<?php

namespace App\GraphQL\Directives\Schedual_days;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateSchedualDaysValidationDirective extends ValidationDirective
{
  
    public function rules(): array
    {
      return [
        'class_id' => 'required',
        'day' => 'required'
      ];
    }
}
