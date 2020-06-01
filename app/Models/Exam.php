<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['class_category_id', 'name', 'possible', 'description', 'qa', 'attempt', 'due_at',];

    protected $casts = [
        'qa' => 'object',
        'due_at' => 'date'
    ];
}
