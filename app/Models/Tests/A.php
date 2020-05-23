<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class A extends Model
{
    use SoftDeletes;

    protected $fillable = [
        
    ];
        
}
