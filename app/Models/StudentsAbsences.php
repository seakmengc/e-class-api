<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StudentsAbsences extends Model
{
    //
    protected $fillable = ['student_id', 'has_permission', 'class_attendance_id', 'reason'];

    public function user(): BlongsTo
    {
      return $this->belongsTo(User::class, 'student_id');
    }

    public function classes(): BelongsToMany
    {
      return $this->belongsToMany(ClassAttendance::class);
    }

}
