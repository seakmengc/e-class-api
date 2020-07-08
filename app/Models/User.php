<?php

namespace App\Models;

use App\Observers\UserObserver;
use App\Traits\TimestampsShouldInHumanReadable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, TimestampsShouldInHumanReadable;

    protected $guard_name = 'api';

    protected $fillable = ['username', 'email', 'phone_number', 'password'];

    public function identity(): HasOne
    {
        return $this->hasOne(Identity::class);
    }

    public function learnings(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'student_has_classes', 'student_id', 'class_id');
    }

    public function teachings(): HasMany
    {
        return $this->hasMany(Classes::class, 'teacher_id');
    }

    public function myExams()
    {
        return $this->belongsToMany(StudentExam::class, 'student_exams', 'student_id', 'exam_id');
    }

    public function isAStudentIn($classId)
    {
        return $this->learnings()->whereId($classId)->exists();
    }

    public function isATeacherOf(int $classId)
    {
        return $this->teachings()->whereId($classId)->exists();
    }

    public function isTeachingThis(User $student)
    {
        return $this->teachings()->whereIn('id', $student->learnings()->pluck('id'))->exists();
    }

    public function findForPassport($username)
    {
        return $this->where(self::usernameOrEmail($username), $username)->first();
    }

    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isUser()
    {
        return $this->hasRole('user');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public static function usernameOrEmail($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL))
            return 'email';

        return 'username';
    }

    public function getUnreadNotificationsCountAttribute()
    {
        return $this->unreadNotifications()->count();
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->username = strtolower($user->username);
            $user->email = strtolower($user->email);

            if ($user->isDirty('password'))
                $user->password = bcrypt($user->password);
        });

        static::deleting(function (User $user) {
            $user->identity->delete();
        });
    }
}
