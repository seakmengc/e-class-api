<?php

namespace App\GraphQL\Mutations\ClassContent;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\ClassContent;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateClassContent
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
		$classContent = ClassContent::create([
			'name' => $args['name'],
			'description' => $args['description'],
			'class_id' => $args['class_id']
		]);

		if (isset($args['file_url'])) {
			$classContent->addMedia($args['file_url'])->toMediaCollection('class-content');
			$fullPathOnDisk = $classContent->getMedia('class-content')->first()->file_name;
			$classContent->update([
				'file_url' => $fullPathOnDisk
			]);
		}

		return $classContent;
	}
}
