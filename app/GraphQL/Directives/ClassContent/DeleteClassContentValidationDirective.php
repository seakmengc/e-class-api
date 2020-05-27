<?php

namespace App\GraphQL\Directives\ClassContent;


use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class DeleteClassContentValidationDirective extends ValidationDirective
{


    public function rules(): array
    {
      return [
        'id' => 'required'
      ];
    }
}
