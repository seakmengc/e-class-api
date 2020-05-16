<?php

namespace App\GraphQL\Directives\Classes;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassesValidationDirective extends ValidationDirective
{

  public function rules(): array
  {
      return [
        'name' => 'required|min:4|unique:classes',
        'code' => 'required|min:4|unique:classes',
        'teacher_id' => 'unique:classes'
      ];
  }
}
