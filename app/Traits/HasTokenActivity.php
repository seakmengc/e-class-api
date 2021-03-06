<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;

trait HasTokenActivity
{

    /**
     * @param array $credentials
     *
     * @throws AuthenticationException
     *
     * @return mixed
     */
    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            throw new CustomException('Wrong username or password');
        }

        return $decodedResponse;
    }

    /**
     * @param array  $args
     * @param string $grantType
     *
     * @return mixed
     */
    public function buildCredentials(array $args = [], $grantType = 'password')
    {
        $args = collect($args);
        $credentials = $args->except('directive')->toArray();
        $credentials['client_id'] = $args->get('client_id', config('auth.password_grant.client_id'));
        $credentials['client_secret'] = $args->get('client_secret', config('auth.password_grant.client_secret'));
        $credentials['grant_type'] = $grantType;

        return $credentials;
    }
}
