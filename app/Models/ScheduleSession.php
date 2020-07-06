<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduleSession extends Model
{
    protected $table = 'schedule_sessions';

    public $timestamps = false;

    protected $fillable = ['schedule_id', 'start_time', 'end_time'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ClassAttendance::class);
    }

    public function getStartTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['start_time'])->toTimeString('minute');
    }

    public function getEndTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['end_time'])->toTimeString('minute');
    }
}
