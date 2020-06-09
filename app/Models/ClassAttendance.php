<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassAttendance extends Model
{
    //
    protected $fillable = ['schedule_sessions_id', 'date'];

    public function schedule_sessions(): BelongsTo
    {
      return $this->belongsTo(ScheduleSession::class, 'schedule_sessions_id');
    }
}
