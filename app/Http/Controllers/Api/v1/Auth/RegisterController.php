<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:5|unique:users',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        return $this->created(User::create($data));
    }
}
