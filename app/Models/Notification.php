<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Notification extends Model
{
    protected $fillable = ['type', 'notifiable_type', 'notifiable_id', 'data'];

    protected $casts = [
        'data' => 'collection',
        'read_at' => 'datetime'
    ];

    public function isRead()
    {
        return (bool) $this->read_at;
    }

    public function paginate($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        return Notification::where('notifiable_id', $context->user->id)
            ->where('notifiable_type', get_class($context->user));
    }
}
