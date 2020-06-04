<?php

namespace App\GraphQL\Directives\Forum;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdateCommentValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:forums',
            'comments.*.id' => 'required|integer|exists:comments',
            'comment' => 'required|string',
        ];
    }
}
