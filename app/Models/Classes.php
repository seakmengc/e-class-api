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
      'id', 'name', 'code',
    ];

    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class, 'teacher_id');
    }

    public function identity(): belongsTo
    {
      return $this->belongsTo(Identity::class, 'teacher_id');
    }


}
