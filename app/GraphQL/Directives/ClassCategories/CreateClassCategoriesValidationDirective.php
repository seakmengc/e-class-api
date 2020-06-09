<?php

namespace App\GraphQL\Directives\ClassCategories;

use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassCategoriesValidationDirective extends ValidationDirective
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
