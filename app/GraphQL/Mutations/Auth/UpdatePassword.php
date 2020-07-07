<?php

namespace App\GraphQL\Mutations\Auth;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Exceptions\ValidationException;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;

class UpdatePassword
{
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
        $user = $context->user();
        if (!Hash::check($args['old_password'], $user->password)) {
            throw new ValidationException([
                'password' => __('Current password is incorrect'),
            ], 'Validation Exception');
        }
        $user->password = $args['password'];
        $user->save();

        return [
            'status'  => 'PASSWORD_UPDATED',
            'message' => __('Your password has been updated'),
        ];
    }
}
