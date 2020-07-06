<?php

namespace App\GraphQL\Mutations\Classes;

use App\Models\Classes;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UpdateClass
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $class = Classes::findOrFail($args['id']);
        $class->update($args);

        if (isset($args['teacher']['disconnect'])) {
            if ($args['teacher']['disconnect'])
                $class->teacher()->disassociate();
        } else
            $class->teacher()->associate($args['teacher']['connect']);

        if (isset($args['students']['sync']))
            $class->students()->sync($args['students']['sync']);

        if (isset($args['schedule_sessions']['sync'])) {
            $class->schedules()->delete();
            foreach ($args['schedule_sessions']['sync'] as $scheduleSession) {
                $schedule = $class->schedules()->firstOrCreate([
                    'day' => Arr::get($scheduleSession, 'schedule.upsert.day')
                ]);

                $schedule->sessions()->firstOrCreate([
                    'start_time' => Arr::get($scheduleSession, 'start_time'),
                    'end_time' => Arr::get($scheduleSession, 'end_time'),
                ]);
            }
        }

        return $class;
    }
}
