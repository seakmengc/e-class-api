<?php

namespace App\Models;

use App\Traits\HasAuthIdFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasAuthIdFields;

    protected $fillable = ['comment'];

    protected $authIdFields = ['author_id'];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'full_name' => '[Deleted Author]'
        ]);
    }
}
