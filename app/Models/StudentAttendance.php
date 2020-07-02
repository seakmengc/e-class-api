<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ClassAttendance;

class StudentAttendance extends Model
{
    protected $fillable = ['class_attendance_id', 'attendance_type', 'student_id'];

    public $timestamps = false;

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function classAttendance(): BelongsTo
    {
        return $this->belongsTo(ClassAttendance::class, 'class_attendance_id');
    }
}
