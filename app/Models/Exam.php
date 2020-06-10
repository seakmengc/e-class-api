<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Exam extends Model
{
    protected $fillable = ['class_category_id', 'name', 'possible', 'description', 'qa', 'attempts', 'due_at', 'publishes_at'];

    protected $casts = [
        'qa' => 'collection',
        'due_at' => 'datetime',
        'publishes_at' => 'datetime',
    ];

    public function classCategory(): BelongsTo
    {
        return $this->belongsTo(ClassCategory::class);
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

        return $modified->union($original);
    }
}
