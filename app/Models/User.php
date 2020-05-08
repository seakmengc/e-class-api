<?php

namespace App\Models;

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
        if (filter_var($username, FILTER_VALIDATE_EMAIL))
            return $this->where('email', $username)->first();

        return $this->where('username', $username)->first();
    }
}
