<?php

namespace App\Models;

use App\Exceptions\CustomException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Observers\StudentExamObserver;
use DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudentExam extends Model implements HasMedia
{
    use InteractsWithMedia;

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

    public function resolveUploadedFileInAnswer($inputAnswers)
    {
        $exam = $this->exam;
        $inputAnswers = collect($inputAnswers);
        $this->answer = $this->answer->map(function ($answer) use ($inputAnswers, $exam) {
            $qa = $exam->qa->firstWhere('id', $answer['id']);
            $inputAnswer = $inputAnswers->firstWhere('id', $answer['id']);

            if ($qa['type'] === 'upload') {
                if (!isset($inputAnswer['file']))
                    throw new CustomException('File needed in question id: ' . $qa['id']);

                $this->addMediaCollection($exam->id . '.' . $qa['id'])->singleFile();

                $file = $this->addMedia($inputAnswer['file'])
                    ->toMediaCollection($exam->id . '.' . $qa['id']);

                unset($inputAnswer['file']);
                $inputAnswer['file']['url'] = route('api.files.exams.show', [
                    'exam' => $exam->id,
                    'user' => auth()->id(),
                    'questionId' => $qa['id']
                ]);
                $inputAnswer['file']['name'] = $file->file_name;
                return $inputAnswer;
            }

            return $answer;
        })->unique('id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->exam->class();
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function (StudentExam $studentExam) {
            if ($studentExam->isDirty('points')) {
                $class = $studentExam->class()->first();
                $score = 0.0;
                $class->classCategories()->get()->each(function ($classCategory) use ($studentExam, &$score) {
                    $scoreInCat = 0.0;
                    $studentExamsInCategory = StudentExam::whereIn('exam_id', $classCategory->exams()->pluck('id'))->where('student_id', $studentExam->student_id)->get();

                    $studentExamsInCategory->each(function ($studentExamInCategory) use (&$scoreInCat) {
                        $scoreInCat += ($studentExamInCategory->points / $studentExamInCategory->exam->possible);
                    });

                    if ($studentExamsInCategory->isNotEmpty()) {
                        $score = $score + ($scoreInCat / $studentExamsInCategory->count() * $classCategory->weight);
                    }
                });

                DB::table('student_has_classes')->where('student_id', $studentExam->student_id)->where('class_id', $class->id)->update(['score' => $score]);
            }
        });
    }
}
