<?php

namespace App\Models;

use App\Traits\HasAuthIdFields;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasAuthIdFields;

    protected $fillable = ['exam_id', 'answer', 'points'];

    protected $casts = [
        'answer' => 'collection',
    ];

    protected $authIdFields = ['student_id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
