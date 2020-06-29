<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAbsence extends Model
{
	protected $fillable = ['has_permission', 'class_attendance_id', 'reason', 'student_id'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'student_id');
	}

	public function classAttendance(): BelongsTo
	{
		return $this->belongsTo(ClassAttendance::class, 'class_attendance_id');
	}
}
