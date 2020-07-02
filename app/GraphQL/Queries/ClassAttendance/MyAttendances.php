<?php

namespace App\GraphQL\Queries\ClassAttendance;

use App\Models\ClassAttendance;
use App\Models\StudentAttendance;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MyAttendances
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $classAttendanceIds = ClassAttendance::whereClassId($args['class_id'])->pluck('id')->toArray();

        return StudentAttendance::whereStudentId(auth()->id())->whereIn('class_attendance_id', $classAttendanceIds)->get();
    }
}
