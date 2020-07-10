<?php

namespace App\Models;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use App\Traits\HasAuthIdFields;
use App\Traits\TimestampsShouldInHumanReadable;

class Forum extends Model
{
    use HasAuthIdFields, TimestampsShouldInHumanReadable;

    protected $fillable = [
        'class_content_id', 'class_id', 'title', 'description', 'author'
    ];

    protected $authIdFields = ['author_id'];

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Forum $forum) {
            // dd($forum, $forum->classContent);
            $forum->class_id = $forum->classContent->class_id;
            $forum->class_id = 1;
        });

        static::deleted(function (Forum $forum) {
            $forum->comments()->delete();
        });

        static::addGlobalScope('sort', function ($query) {
            return $query->orderBy('created_at', 'desc');
        });
    }
}
