<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Events\ClassUpdated;

class ClassContent extends Model implements HasMedia
{
	use InteractsWithMedia;

	protected $fillable = [
		'name', 'class_id', 'description', 'file_url',
	];

	protected $dispatchesEvents = [
		'saved' => ClassUpdated::class,
	];

	public function class(): BelongsTo
	{
		return $this->belongsTo(Classes::class);
	}
}
