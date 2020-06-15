<?php

namespace App\GraphQL\Mutations\StudentExam;

use App\Events\ClassUpdated;
use App\Listeners\SendEmailNotification;
use App\Models\StudentExam;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GradeStudentExam
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
        $studentExam = StudentExam::findOrFail($args['id']);

        $args['answer'] = StudentExam::updateAnswersById($studentExam->answer, $args['answer']);

        $studentExam->points = $this->calculatePoints($args['answer']);

        $studentExam->update($args);

        event(new ClassUpdated($studentExam));

        return $studentExam;
    }

    private function calculatePoints($answers)
    {
        return collect($answers)->sum('points');
    }
}
