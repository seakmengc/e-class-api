<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Identity extends Model
{
    //photo will transfer in observer to photo_url
    protected $fillable = ['first_name', 'last_name', 'gender', 'contact_number', 'photo'];

    public static $photoPath = 'portraits/';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
