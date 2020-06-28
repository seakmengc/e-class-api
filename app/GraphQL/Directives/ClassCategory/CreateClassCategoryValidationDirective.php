<?php

namespace App\GraphQL\Directives\ClassCategory;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassCategoryValidationDirective extends ValidationDirective
{
	public function rules(): array
	{
		return [
			'class_id' => 'required|integer|exists:classes,id',
			'weight' => 'required|numeric|between:0,100',
			'name' => ['required', 'min:4', Rule::unique('class_categories', 'name')->where('class_id', (int) $this->args['class_id'])],
		];
	}
}
