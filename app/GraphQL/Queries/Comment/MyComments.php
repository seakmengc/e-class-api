<?php

namespace App\GraphQL\Queries\Comment;

use App\Models\Comment;

class MyComments
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return Comment::whereAuthorId(auth()->id())->latest()->limit(10)->get();
    }
}
