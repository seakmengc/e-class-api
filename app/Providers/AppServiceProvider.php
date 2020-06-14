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
use Illuminate\Database\Eloquent\Builder;

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
        Identity::observe(IdentityObserver::class);
    }
}
