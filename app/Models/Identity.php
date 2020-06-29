<?php

namespace App\Models;

use Faker\Provider\Color;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
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

    public function getPhotoUrlAttribute()
    {
        return config('app.url')
            . route('api.files.portraits.show', $this->user_id, false);
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

    public static function boot()
    {
        parent::boot();

        static::saving(function (Identity $identity) {
            $identity->first_name = ucwords(strtolower(trim($identity->first_name)));
            $identity->last_name = ucwords(strtolower(trim($identity->last_name)));

            if (isset($identity['photo'])) {
                $identity->addMedia($identity['photo'])->toMediaCollection();
            } elseif ($identity->getMedia()->count() === 0) {
                $avatar = new InitialAvatar();
                $image = $avatar->autoFont()->rounded()->smooth()->background(Color::hexColor())->color('#FFFFFF')->size(128)->name($identity->full_name)->generate();

                $identity->addMediaFromBase64($image->encode('data-url', 100))->toMediaCollection();
            }

            unset($identity['photo']);
        });
    }
}
