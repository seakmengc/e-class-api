<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model implements HasMedia
{
    use InteractsWithMedia;

    //photo will transfer in observer to photo_url
    protected $fillable = ['first_name', 'last_name', 'gender', 'contact_number', 'photo'];

    public static $portraitsCollectionName = 'portraits';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute()
    {
        return config('app.url') . '/portraits/' . $this->user_id;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();

        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 256, 256)
            ->sharpen(10)
            ->keepOriginalImageFormat()
            ->nonQueued();
    }
}
