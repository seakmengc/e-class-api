<?php

namespace App\GraphQL\Directives\Comment;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CommentValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [];
    }
}
