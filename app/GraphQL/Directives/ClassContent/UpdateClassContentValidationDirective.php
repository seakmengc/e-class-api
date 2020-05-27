<?php

namespace App\GraphQL\Directives\ClassContent;


use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateClassContentValidationDirective extends ValidationDirective
{


    public function rules(): array
    {
      return [
        'id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'class_id' => 'required',
        'file_url' => 'required'
      ];
    }
}
