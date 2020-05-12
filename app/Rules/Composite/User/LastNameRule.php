<?php

namespace App\Rules\Composite\User;

use Illuminatech\Validation\Composite\CompositeRule;

class LastNameRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['max:255'];
    }
}
