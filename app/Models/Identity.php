<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    //photo will transfer in observer to photo_url
    protected $fillable = ['first_name', 'last_name', 'gender', 'contact_number', 'photo'];

    public static $photoPath = 'portraits/';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
