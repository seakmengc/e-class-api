<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassContent extends Model
{
    //
    protected $fiilable = [
      'name', 'class_id', 'description', 'file_url',
    ];
}
