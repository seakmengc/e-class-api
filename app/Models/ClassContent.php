<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClassContent extends Model implements HasMedia
{
    use InteractsWithMedia;
    //

    protected $table = 'class_contents';
    //
    protected $guard_name = 'api';
    //

    protected $fillable = [
      'name', 'class_id', 'description', 'file_url',
    ];

    public function classes(): BelongsTo
    {
      return $this->belongsTo('Classes:class');
    }
}
