<?php

namespace App\GraphQL\Queries\ClassCategory;

use App\Models\ClassCategory;

class ClassCategoriesInClass
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return ClassCategory::whereClassId($args['class_id'])->get();
    }
}
