<?php

namespace App\GraphQL\Directives\Helper;

use Closure;
use App\Exceptions\CustomException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;

class IsTeacherOfDirective extends BaseDirective implements FieldMiddleware, DefinedDirective
{
    public static function definition(): string
    {
        return
            /** @lang GraphQL */
            <<<GRAPHQL
"""
Limit field access to teacher in class only.
"""
directive @isTeacherOf(
  """
  The class that user's teaching.
  """
  classId: String!
) on FIELD_DEFINITION
GRAPHQL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $originalResolver = $fieldValue->getResolver();

        return $next(
            $fieldValue->setResolver(
                function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($originalResolver) {
        dd($this, $args, $root, $context, $this->getModelClass(), $originalResolver);

                    $classId = $this->directiveArgValue('classId');
                    // Throw in case of an invalid schema definition to remind the developer
                    if ($classId === null) {
                        throw new DefinitionException("Missing argument 'classId' for directive '@isTeacherOf'.");
                    }

                    $model = $this->getModelClass();
                    dd($model::findOrFail())

                    $user = $context->user();
                    if (
                        // Unauthenticated users don't get to see anything
                        !$user
                        // The user's role has to match have the required role
                        || !$user->teachings()->whereId($classId)->exists()
                    ) {
                        throw new CustomException('User is not a teacher in this class');
                    }

                    return $originalResolver($root, $args, $context, $resolveInfo);
                }
            )
        );
    }
}
