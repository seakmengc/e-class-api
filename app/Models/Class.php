<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classes extends Model
{
  //
  protected $guard_name = 'api';

  protected $fillable = [
    'name', 'code', 'teacher_id'
  ];

  public function teacher(): BelongsTo
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }
}
