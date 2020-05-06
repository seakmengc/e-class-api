<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidator;

class RegisterController extends Controller
{
    public function store(RegisterValidator $request)
    {
        // $this->authorize('create', User::class);

        DB::beginTransaction();

        $user = User::create($request->user_validated());
        $user->identity()->create($request->identity_validated());
        //TODO: assign role
        DB::commit();

        return $this->created($user);
    }
}
