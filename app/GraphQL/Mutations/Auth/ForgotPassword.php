<?php

namespace App\GraphQL\Mutations\Auth;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ForgotPassword
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

        $otp = rand(100000, 999999);
        DB::table('password_resets')->updateOrInsert(
            ['user_id' => $user->id,],
            [
                'token' => bcrypt($otp),
                'created_at' => now()
            ]
        );

        Mail::to($user->email)->sendNow(new ForgotPasswordMail($otp));

        return [
            'status' => 'EMAIL_HAS_BEEN_SENT',
            'statusCode' => 200,
            'message' => 'An OTP token has been sent to your email.'
        ];
    }
}
