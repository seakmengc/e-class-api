<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassAttendance extends Model
{
	protected $fillable = ['schedule_session_id', 'date', 'class_id'];

	public function scheduleSessions(): BelongsTo
	{
		return $this->belongsTo(ScheduleSession::class);
	}
	public function class(): BelongsTo
	{
		return $this->belongsTo(Classes::class, 'class_id');
	}

	public function studentAttendances(): HasMany
	{
		return $this->hasMany(StudentAttendance::class);
	}
}
