<?php

namespace App\Models;

use App\Traits\HasAuthIdFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Forum extends Model
{
    use HasAuthIdFields;

    protected $fillable = [
        'class_content_id', 'class_id', 'title', 'description', 'author'
    ];

    protected $authIdFields = ['author_id'];

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function classContent(): BelongsTo
    {
        return $this->belongsTo(ClassContent::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleted(function (Forum $forum) {
            $forum->comments()->delete();
        });
    }
}
