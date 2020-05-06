<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'phone_number' => '',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|in:male,female,others',
            'photo' => 'image|max:5120'
        ];
    }

    public function user_validated()
    {
        $data = parent::validated();

        return [
            'username' => $data['username'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'password' => $data['password'],
        ];
    }

    public function identity_validated()
    {
        $data = parent::validated();

        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'photo' => $data['photo'] ?? null,
        ];
    }
}
