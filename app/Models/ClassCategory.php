<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassCategory extends Model
{
	protected $fillable = ['class_id', 'name', 'weight'];

	public function class(): BelongsTo
	{
		return $this->belongsTo(Classes::class, 'class_id');
	}

	public function exams(): HasMany
	{
		if (auth()->id() == $this->teacher_id) {
			return $this->hasMany(Exam::class);
		}

		return $this->hasMany(Exam::class)->where('publishes_at', '!=', null)->where('publishes_at', '<=', now());
	}
}
