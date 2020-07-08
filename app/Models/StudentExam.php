<?php

namespace App\Models;

use App\Exceptions\CustomException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Observers\StudentExamObserver;
use App\Traits\TimestampsShouldInHumanReadable;
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

        static::saving(function (StudentExam $studentExam) {
            if (isset($studentExam->attempts))
                $studentExam->increment('attempts');
            else
                $studentExam->attempts = 1;
        });
    }
}
