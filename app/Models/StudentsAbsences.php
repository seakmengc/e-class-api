<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentsAbsences extends Model
{
  protected $fillable = ['student_id', 'has_permission', 'class_attendance_id', 'reason'];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'student_id');
  }

  public function class(): BelongsToMany
  {
    return $this->belongsToMany(ClassAttendance::class);
  }
}
