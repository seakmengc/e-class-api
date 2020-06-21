<?php

namespace App\GraphQL\Directives\Helper;

use Spatie\Permission\Exceptions\UnauthorizedException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;
use Closure;
use App\Exceptions\CustomException;
use App\Exceptions\ClassException;

class CanAccessDirective extends BaseDirective implements FieldMiddleware, DefinedDirective
{
    public static function definition(): string
    {
        return
            /** @lang GraphQL */
            <<<GRAPHQL
"""
Limit field access to users of a certain role.
"""
directive @canAccess(
  """
  The name of the role authorized users need to have.
  """
  requiredRole: String!
) on FIELD_DEFINITION
GRAPHQL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $originalResolver = $fieldValue->getResolver();

        return $next(
            $fieldValue->setResolver(
                function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($originalResolver) {

                    $requiredRole = $this->directiveArgValue('requiredRole');

                    // Throw in case of an invalid schema definition to remind the developer
                    if ($requiredRole === null) {
                        throw new DefinitionException("Missing argument 'requiredRole' for directive '@canAccess'.");
                    }

                    $user = $context->user();
                    if (
                        // Unauthenticated users don't get to see anything
                        !$user
                        // The user's role has to match have the required role
                        || !$user->hasRole($requiredRole)
                    ) {
                        throw new CustomException('User cannot perform this action');
                    }

                    return $originalResolver($root, $args, $context, $resolveInfo);
                }
            )
        );
    }
}
