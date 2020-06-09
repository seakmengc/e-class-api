<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsAbsences extends Model
{
    //
    protected $fillable = ['student_id', 'has_permission', 'class_attendance_id', 'reason'];
}
