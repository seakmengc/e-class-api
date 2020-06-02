<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleSession extends Model
{
    protected $table = 'schedule_sessions';

    public $timestamps = false;

    protected $fillable = ['start_time', 'end_time'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
