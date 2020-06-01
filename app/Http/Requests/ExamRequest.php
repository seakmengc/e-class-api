<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'class_category_id' => ['bail', 'required', 'integer'],
            'name' => ['bail', 'required', 'string', 'max:255'],
            'possible' => ['bail', 'required'],
            'description' => ['bail'],
            'qa' => ['bail', 'json'],
            'attempt' => ['bail', 'required', 'integer'],
            'due_at' => ['bail', 'required', 'date'],
        ];
    }
}
