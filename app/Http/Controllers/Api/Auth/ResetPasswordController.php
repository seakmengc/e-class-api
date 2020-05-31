<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $password = $request->password;
        unset($request['password']);
        dd($request);
        if ($request->hasValidSignature())
            return 1;
        else
            return -1;
    }
}
