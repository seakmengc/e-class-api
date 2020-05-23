<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ARequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['uuid' => ['bail', 'string', 'max:255'],
'username' => ['bail', 'required', 'string', 'max:255'],
'email' => ['bail', 'required', 'string', 'max:255'],
'password' => ['bail', 'required', 'string', 'max:255'],
];
    }
}
