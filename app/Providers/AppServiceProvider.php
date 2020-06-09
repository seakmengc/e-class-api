<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Identity;
use App\Observers\UserObserver;
use App\Observers\IdentityObserver;
use Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Identity::observe(IdentityObserver::class);
    }
}
