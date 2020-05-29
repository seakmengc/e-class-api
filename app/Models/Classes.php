<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
  protected $table = 'classes';

  protected $fillable = [
    'name', 'code', 'teacher_id'
  ];

  public function teacher(): BelongsTo
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }

  public function students(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'student_has_classes', 'class_id', 'student_id');
  }
}
