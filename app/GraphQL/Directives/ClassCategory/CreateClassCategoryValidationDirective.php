<?php

namespace App\GraphQL\Directives\ClassCategory;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassCategoryValidationDirective extends ValidationDirective
{
  public function rules(): array
  {
    return [
      'name' => 'required|min:4|unique:class_categories',
      'class_id' => 'required',
      'weight' => 'required'
    ];
  }
}
