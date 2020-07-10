<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\ClassConst;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TimestampsShouldInHumanReadable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
	use TimestampsShouldInHumanReadable;

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

	public function classContents(): HasMany
	{
		return $this->hasMany(ClassContent::class, 'class_id');
	}

	public function classAttendances(): HasMany
	{
		return $this->hasMany(ClassAttendance::class, 'class_id')->orderBy('date', 'desc');
	}

	public function exams(): HasMany
	{
		if (auth()->id() == $this->teacher_id)
			return $this->hasMany(Exam::class, 'class_id');

		return $this->hasMany(Exam::class, 'class_id')->where('publishes_at', '!=', null)->where('publishes_at', '<=', now());
	}

	public function schedules(): HasMany
	{
		return $this->hasMany(Schedule::class, 'class_id')->orderByRaw("FIELD(day, \"monday\", \"tuesday\", \"wednesday\", \"thursday\", \"friday\", \"saturday\", \"sunday\")");
	}

	public function getStudentScores()
	{
		$studentIds = $this->students()->pluck('id')->toArray();

		$scores = DB::table('student_has_classes')->whereIn('student_id', $studentIds)->where('class_id', $this->id)->get();

		$overall = $this->classCategories()->sum('weight');

		return $scores->map(function ($score) use ($overall) {
			return [
				'student_id' => $score->student_id,
				'score' => $score->score,
				'overall' => $overall
			];
		});
	}
}
