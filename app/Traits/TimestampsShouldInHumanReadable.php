<?php

namespace App\Traits;

use Carbon\Carbon;

trait TimestampsShouldInHumanReadable
{
	public function getCreatedAtAttribute()
	{
		return Carbon::parse($this->attributes['created_at'])->diffForHumans();
	}

	public function getUpdatedAtAttribute()
	{
		return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
	}
}
