<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\TimestampsShouldInHumanReadable;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Notification extends Model
{
    use TimestampsShouldInHumanReadable;

    protected $fillable = ['type', 'notifiable_type', 'notifiable_id', 'data'];

    protected $keyType = 'string';

    protected $casts = [
        'data' => 'collection',
        'read_at' => 'datetime'
    ];

    public function isRead()
    {
        return (bool) $this->read_at;
    }

    public static function boot()
    {
        parent::boot();

        static::retrieved(function (Notification $notification) {
            if (is_null($notification->read_at)) {
                $notification->markAsRead();
                $notification->read_at = null;
            }
        });
    }

    public function getReadAtAttribute()
    {
        return Carbon::parse($this->attributes['read_at'])->diffForHumans();
    }

    public function markAsRead()
    {
        $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
    }
}
