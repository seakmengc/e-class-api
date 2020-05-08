<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    protected $guard_name = 'api';

    protected $fillable = ['username', 'email', 'phone_number', 'password'];

    public function identity()
    {
        return $this->hasOne(Identity::class);
    }

    public function findForPassport($username)
    {
        return $this->whereUsername($username)->first();
    }
}
