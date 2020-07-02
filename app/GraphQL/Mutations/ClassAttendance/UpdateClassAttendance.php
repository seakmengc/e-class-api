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

        $studentAttendances = collect($args['student_attendances']);
        $classAttendance->studentAttendances->each(function ($studentAttendance) use ($studentAttendances) {
            $data = $studentAttendances->where('id', $studentAttendance->id)->first();
            if ($data)
                $studentAttendance->update($data);
        });

        return $classAttendance;
    }
}
