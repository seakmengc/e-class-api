<?php

namespace App\GraphQL\Mutations\Auth;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\User;
use App\Traits\HasTokenActivity;

class Login
{
    use HasTokenActivity;

    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = $this->buildCredentials($args);

        $response = $this->makeRequest($credentials);

        $user = User::where($this->usernameOrEmail($args['username']), $args['username'])->firstOrFail();

        return array_merge($response, ['user' => $user]);
    }

    public function usernameOrEmail($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL))
            return 'email';

        return 'username';
    }
}
