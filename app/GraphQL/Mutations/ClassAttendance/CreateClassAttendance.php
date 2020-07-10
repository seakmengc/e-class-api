<?php

namespace App\GraphQL\Mutations\ClassAttendance;

use App\Models\ClassAttendance;

class CreateClassAttendance
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $classAttendance =  ClassAttendance::create($args);
        dd($args);
        $classAttendance->studentAttendances()->createMany($args['student_attendances']);

        return $classAttendance;
    }
}
