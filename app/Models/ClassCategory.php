<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ClassCategory extends Model
{
	protected $fillable = ['class_id', 'name', 'weight'];

	public function class(): BelongsTo
	{
		return $this->belongsTo(Classes::class, 'class_id');
	}

	public function exams(): HasMany
	{
		return $this->hasMany(Exam::class);
	}
}
