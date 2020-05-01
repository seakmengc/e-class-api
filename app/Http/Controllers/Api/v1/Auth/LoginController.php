<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

        $user = User::firstWhere($this->resolveIdentity($request->identity), $request->identity);
        if (!$user)
            throw new AuthenticationException;
        elseif (!password_verify($request->password, $user->password))
            throw new AuthenticationException('Username or Password is wrong');

        $token = $user->createToken('PAT');

        return $this->created([
            'user' => $user,
            'token' => [
                'accessToken' => $token->accessToken,
                'expires_at' => $token->token->expires_at
            ]
        ]);
    }

    public function logout()
    {
    }

    public function logout_all()
    {
    }

    private function resolveIdentity($identity)
    {
        if (filter_var($identity, FILTER_VALIDATE_EMAIL))
            return 'email';
        else
            return 'username';
    }

    public function getTokenAndRefreshToken(Client $oClient, $username, $password)
    {
        $response = Http::post('http://localhost:8003/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $username,
                'password' => $password,
                'scope' => '*',
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        dd($result);
        return response()->json($result, $this->successStatus);
    }
}
