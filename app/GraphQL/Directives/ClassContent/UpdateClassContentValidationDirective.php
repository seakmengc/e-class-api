<?php

namespace App\GraphQL\Directives\ClassContent;

use App\Models\ClassContent;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use Illuminate\Validation\Rule;

class UpdateClassContentValidationDirective extends ValidationDirective
{
	public function rules(): array
	{
		$classCon = ClassContent::findOrFail((int) $this->args['id']);

		return [
			'name' => ['min:4', Rule::unique('class_contents', 'name')->where('class_id', (int) $this->args['class_id'])->ignore($classCon->id)],
			'description' => '',
			'file' => 'file'
		];
	}
}
