<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedualDays extends Model
{
    //
    protected $fillable = [
      'class_id', 'day'
    ];

    public function class(): BelongsTo
    {
      return $this->BelongsTo(Classes::class);
    }
}
