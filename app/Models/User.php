<?php

namespace App\Models;

use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, Messagable;

    protected $guard_name = 'api';

    protected $fillable = ['username', 'email', 'phone_number', 'password'];

    public function identity(): HasOne
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
