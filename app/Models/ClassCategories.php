<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ClassCategories extends Model
{
    //
    protected $fillable = ['class_id', 'name', 'weight'];

    public function class(): BelongsTo
    {
      return $this->belongsTo(Classes::class);
    }
}
