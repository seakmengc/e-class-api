<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class ClassContent extends Model implements HasMedia
{
  use InteractsWithMedia;

  protected $fillable = [
    'name', 'class_id', 'description', 'file_url',
  ];

  public function class(): BelongsTo
  {
    return $this->belongsTo(Classes::class);
  }
}
