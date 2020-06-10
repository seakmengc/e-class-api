<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassCategory extends Model
{
  protected $fillable = ['class_id', 'name', 'weight'];

  public function class(): BelongsTo
  {
    return $this->belongsTo(Classes::class);
  }

  public function exams(): HasMany
  {
    return $this->hasMany(Exam::class);
  }
}
