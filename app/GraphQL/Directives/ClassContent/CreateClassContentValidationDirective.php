<?php

namespace App\GraphQL\Directives\ClassContent;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreateClassContentValidationDirective extends ValidationDirective
{
	public function rules(): array
	{
		return [
			'class_id' => 'required|exists:classes,id',
			'name' => ['required', 'min:4', Rule::unique('class_contents', 'name')->where('class_id', (int) $this->args['class_id'])],
			'description' => 'required|string',
			'file' => 'mimes:png,jpeg,jpg,zip,pdf,docx,pptx,xlsx'
		];
	}
}
