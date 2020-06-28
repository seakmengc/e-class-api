<?php

namespace App\GraphQL\Mutations\ClassContent;

use App\Exceptions\ClassContentException;
use App\Exceptions\CustomException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\ClassContent;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateClassContent
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
    $class_id = $args['class_id'];
    $teacher_id = Classes::findOrFail($class_id)->teacher_id;
    $user_id = User::findOrFail($teacher_id)->id;

    if (Auth::id() !== $user_id) {
      throw new ClassContentException(
        'Unantorize to update since you are not owner of this class content',
        'Unanthorize to update.'
      );
    } else {
      $classContent = ClassContent::findOrFail($args['id']);
      $classContent->update([
        'name' => $args['name'],
        'description' => $args['description'],
        'class_id' => $args['class_id']
      ]);
      //delete previous media
      $classContent->clearMediaCollection('class-content');

      $Media = $classContent->addMedia($args['file'])->toMediaCollection('class-content');
      $fullPathOnDisk = $classContent->getMedia('class-content')->first()->file_name;

      return $classContent;
    }
  }
}
