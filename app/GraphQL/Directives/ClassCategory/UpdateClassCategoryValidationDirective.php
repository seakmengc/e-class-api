<?php

namespace App\GraphQL\Directives\ClassCategory;

use App\Models\ClassCategory;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Illuminate\Validation\Rule;

class UpdateClassCategoryValidationDirective extends ValidationDirective
{
    public function rules(): array
    {
        $classCat = ClassCategory::findOrFail((int) $this->args['id']);

        return [
            'weight' => 'required|numeric|between:0,100',
            'name' => ['required', 'min:4', Rule::unique('class_categories', 'name')->where('class_id', $classCat->class_id)->ignore($classCat->id)],
        ];
    }
}
