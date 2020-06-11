<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::refreshTokensExpireIn(now()->addDays(15));
        Passport::tokensExpireIn(now()->addDay());
        Passport::personalAccessTokensExpireIn(now()->addDay());

        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('Admin') ? true : null;
        // });

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            $modelName = substr($modelClass, 11);

            return 'App\Policies\\' . $modelName . 'Policy';
        });
    }
}
