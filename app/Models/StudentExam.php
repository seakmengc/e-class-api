<?php

namespace App\Models;

use App\Exceptions\CustomException;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuthIdFields;
use App\Observers\StudentExamObserver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File as FacadesFile;
use Intervention\Image\File;
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

    public function resolveUploadedFileInAnswer()
    {
        $exam = $this->exam;
        foreach ($this->answer as $value) {
            $qa = $exam->qa->firstWhere('id', $value['id']);
            if ($qa['type'] === 'upload') {
                if (!isset($value['file']))
                    throw new CustomException('File needed in question id: ' . $qa['id']);

                $this->addMediaCollection($exam->id . '.' . $qa['id'])->singleFile();

                $this->addMediaFromRequest(request()->file('file'))
                    ->toMediaCollection($exam->id . '.' . $qa['id']);
            }
        }
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
