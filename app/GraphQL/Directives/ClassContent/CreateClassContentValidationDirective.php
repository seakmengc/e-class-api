<?php

namespace App\GraphQL\Directives\ClassContent;


use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassContentValidationDirective extends ValidationDirective
{


    public function rules(): array
    {
      return [
        'name' => 'required|min:4|unique:class_contents',
        'description' => 'required',
        'class_id' => 'required',
        'file_url' => 'unique:class_contents'
      ];
    }
}
