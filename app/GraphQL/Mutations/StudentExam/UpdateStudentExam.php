<?php

namespace App\GraphQL\Mutations\StudentExam;

use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use Arr;
use App\Models\StudentExam;
use App\Models\Exam;
use App\Exceptions\CustomException;

class UpdateStudentExam
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
        $exam = Exam::findOrFail($args['exam_id']);

        if ($exam->isDue())
            throw new CustomException('Exam is already due.');

        $studentExam = $exam->submittings()->whereStudentId(auth()->id())->first();

        if ($studentExam->attempts === $exam->attempts)
            throw new NotAcceptableHttpException('Number of attempts has exceeded');

        if (isset($args['answer']))
            $args['answer'] = StudentExam::updateAnswersById($studentExam->answer, $args['answer']);

        $studentExam->update($args);

        return $studentExam;
    }
}
