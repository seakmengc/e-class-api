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
    use Notifiable, HasApiTokens, HasRoles;

    protected $guard_name = 'api';

    protected $fillable = ['username', 'email', 'phone_number', 'password'];

    public function identity(): HasOne
    {
        return $this->hasOne(Identity::class);
    }

    public function learnings()
    {
        return $this->belongsToMany(Classes::class, 'student_has_classes', 'student_id', 'class_id');
    }

    public function teachings()
    {
        return $this->hasMany(Classes::class, 'teacher_id');
    }

    public function findForPassport($username)
    {
        return $this->where(self::usernameOrEmail($username), $username)->first();
    }

    public static function usernameOrEmail($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL))
            return 'email';

        return 'username';
    }
}
