<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => ['bail', 'required', 'integer'],
            'exam_id' => ['bail', 'required', 'integer'],
            'answer' => ['bail', 'json'],
            'point' => ['bail'],
        ];
    }
}
