<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\HasAuthIdFields;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentAbsence extends Model
{
  use HasAuthIdFields;

  protected $fillable = ['has_permission', 'class_attendance_id', 'reason'];

  protected $authIdFields = ['student_id'];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'student_id');
  }

  public function class(): BelongsToMany
  {
    return $this->belongsToMany(ClassAttendance::class);
  }
}
