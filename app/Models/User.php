<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

        static::observe(UserObserver::class);
    }
}
