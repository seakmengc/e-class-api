<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidator;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(RegisterValidator $request)
    {
        DB::beginTransaction();

        $user = User::create($request->user_validated());
        $user->identity()->create($request->identity_validated());
        //TODO: 

        DB::commit();

        return $this->created([
            $user, $user->identity
        ]);
    }
}
