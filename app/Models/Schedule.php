<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $table = 'schedules';

    public $timestamps = false;

    protected $fillable = ['day'];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}
