<?php

namespace App\GraphQL\Queries\Forum;

use App\Models\Forum;

class MyForums
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return Forum::whereAuthorId(auth()->id())->latest()->limit(10)->get();
    }
}
