<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPassword
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
        $user = User::where(User::usernameOrEmail($args['username']), $args['username'])
            ->firstOrFail();

        $pwReset = DB::table('password_resets')->where('user_id', $user->id)->first();
        if (!$pwReset)
            throw new NotFoundHttpException('User not found');

        if (!password_verify($args['otp'], $pwReset->token))
            throw new Exception('OTP incorrect');

        $user->update([
            'password' => $args['password']
        ]);

        return [
            'status' => 'RESET_PASSWORD',
            'statusCode' => 200,
            'message' => 'User\'s password has been reset.'
        ];
    }
}
