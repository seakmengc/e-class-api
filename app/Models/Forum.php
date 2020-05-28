<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Forum extends Model
{
    protected $fillable = [
        'class_content_id', 'title', 'description', 'author'
    ];

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function classContent(): BelongsTo
    {
        return $this->belongsTo(ClassContent::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
