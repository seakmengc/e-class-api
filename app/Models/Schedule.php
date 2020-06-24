<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $table = 'schedules';

    public $timestamps = false;

    protected $fillable = ['day', 'class_id'];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ScheduleSession::class, 'schedule_id')->orderBy('start_time');
    }
}
