<?php

namespace App\GraphQL\Queries\Classes;

use App\Models\Classes;
use App\Models\ClassCategory;
use Illuminate\Support\Facades\DB;

class StudentScoresInClass
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $studentIds = Classes::findOrFail($args['class_id'])->students()->pluck('id')->toArray();

        $scores = DB::table('student_has_classes')->whereIn('student_id', $studentIds)->where('class_id', $args['class_id'])->get();

        $overall = ClassCategory::where('class_id', $args['class_id'])->sum('weight');

        return $scores->map(function ($score) use ($overall) {
            return [
                'student_id' => $score->student_id,
                'score' => $score->score,
                'overall' => $overall
            ];
        });
    }
}
