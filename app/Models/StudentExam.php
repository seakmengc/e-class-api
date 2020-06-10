<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuthIdFields;
use App\Observers\StudentExamObserver;

class StudentExam extends Model
{
    protected $fillable = ['student_id', 'exam_id', 'answer', 'points'];

    protected $casts = [
        'answer' => 'collection',
    ];

    public static function updateAnswersById($original, $inputAnswers): Collection
    {
        $inputAnswers = collect($inputAnswers)->keyBy('id');

        $modified = $original->whereIn('id', $inputAnswers->keys())
            ->map(function ($question) use ($inputAnswers) {
                $currInputQuestion = $inputAnswers[$question['id']];

                foreach ($currInputQuestion as $key => $value)
                    $question[$key] = $value;

                return $question;
            });

        return $modified->union($original)->values();
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function booted()
    {
        static::observe(StudentExamObserver::class);
    }
}
