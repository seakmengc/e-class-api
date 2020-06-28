<?php

namespace App\GraphQL\Mutations\ClassContent;

use App\Exceptions\ClassContentException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\ClassContent;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteClassContent
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


        $class_id = ClassContent::findOrFail($args['id'])->class_id;
        $teacher_id = Classes::findOrFail($class_id)->teacher_id;
        $user_id = User::findOrFail($teacher_id);
        if (Auth::id() !== $user_id) {
            throw new ClassContentException(
                'Unantorize to delete since you are not owner of this class content',
                'Unanthorize to delete.'
            );
        }
        $classContent = ClassContent::findOrFail($args['id']);
        $classContent->delete();
        //delete previous media
        $classContent->clearMediaCollection('class-content');

        return $classContent;
    }
}
