<?php

namespace App\Models;

use App\Events\ClassUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class Exam extends Model
{
    protected $fillable = ['class_category_id', 'class_id', 'name', 'possible', 'description', 'qa', 'attempts', 'due_at', 'publishes_at'];

    protected $casts = [
        'qa' => 'collection',
        'due_at' => 'datetime',
        'publishes_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => ClassUpdated::class,
    ];

    public function hiddenBasedRole()
    {
        if (auth()->id() === $this->class->teacher_id)
            return $this;

        return collect($this)->except(['qa']);
    }

    public function isNotDue()
    {
        if (optional($this->due_at)->isPast())
            throw new NotAcceptableHttpException('Exam is already due.');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function classCategory(): BelongsTo
    {
        return $this->belongsTo(ClassCategory::class, 'class_category_id');
    }

    public function submittings(): HasMany
    {
        return $this->hasMany(StudentExam::class, 'exam_id');
    }

    public static function updateQuestionsById($original, $inputQuestions): Collection
    {
        $inputQuestions = collect($inputQuestions)->keyBy('id');

        $modified = $original->whereIn('id', $inputQuestions->keys())
            ->map(function ($question, $ind) use ($inputQuestions) {
                $currInputQuestion = $inputQuestions[$question['id']];
                // dd($currInputQuestion, $inputQuestions, $question);
                foreach ($currInputQuestion as $key => $value)
                    $question[$key] = $value;

                return $question;
            });

        return $modified->union($original)->values();
    }
}
