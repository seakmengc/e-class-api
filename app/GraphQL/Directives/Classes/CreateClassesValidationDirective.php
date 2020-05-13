<?php

namespace App\GraphQL\Directives\Classes;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;

class CreateClassesValidationDirective extends BaseDirective
{

  public function rules(): array
  {
      return [
        'name' => 'required|min::4|unique::classes',
        'code' => 'required|unique::classes'
        // 'teacher_id' => 'required|unique::classes'
      ];
  }
}
