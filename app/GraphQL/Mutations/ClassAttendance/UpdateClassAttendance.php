<?php

namespace App\GraphQL\Mutations\ClassAttendance;

use App\Models\ClassAttendance;

class UpdateClassAttendance
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $classAttendance =  ClassAttendance::findOrFail($args['id']);

        $studentAttendancesInput = collect($args['student_attendances']);
        $classAttendance->studentAttendances->each(function ($studentAttendance) use ($studentAttendancesInput) {
            $data = $studentAttendancesInput->where('student_id', $studentAttendance->id)->first();
            if ($data)
                $studentAttendance->update($data);
        });

        return $classAttendance;
    }
}
