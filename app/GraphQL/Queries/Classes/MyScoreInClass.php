<?php

namespace App\GraphQL\Queries\Classes;

use App\Models\ClassCategory;
use Illuminate\Support\Facades\DB;

class MyScoreInClass
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $score = DB::table('student_has_classes')->where('student_id', auth()->id())->where('class_id', $args['class_id'])->first();

        return [
            'student_id' => auth()->id(),
            'score' => $score->score,
            'overall' => ClassCategory::where('class_id', $args['class_id'])->sum('weight')
        ];
    }
}
