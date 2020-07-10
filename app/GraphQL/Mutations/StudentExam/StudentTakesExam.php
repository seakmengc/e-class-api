<?php

namespace App\GraphQL\Mutations\StudentExam;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\StudentExam;
use App\Models\Exam;
use App\Exceptions\CustomException;

class StudentTakesExam
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

        $studentExam = StudentExam::firstOrNew(collect($args)->only(['exam_id', 'student_id'])->toArray());

        if ($studentExam->attempts >= $exam->attempts)
            throw new CustomException('Number of attempts has exceeded');

        $studentExam->fill($args);
        $studentExam->resolveUploadedFileInAnswer($args['answers']);
        if (isset($studentExam->attempts))
            $studentExam->increment('attempts');
        else
            $studentExam->attempts = 1;
        $studentExam->save();

        return $studentExam;
    }
}
