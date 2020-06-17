<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'classes';

	protected $fillable = [
		'name', 'code', 'teacher_id'
	];

	public function teacher(): BelongsTo
	{
		return $this->belongsTo(User::class, 'teacher_id');
	}

	public function students(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'student_has_classes', 'class_id', 'student_id');
	}

	public function classCategories(): HasMany
	{
		return $this->hasMany(ClassCategory::class, 'class_id');
	}

	public function exams(): HasMany
	{
		return $this->hasMany(Exam::class, 'class_id');
	}

	public function schedules(): HasMany
	{
		return $this->hasMany(Schedule::class, 'class_id');
	}
}
