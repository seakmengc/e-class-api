<?php

namespace App\Rules\Composite\User;

use Illuminatech\Validation\Composite\CompositeRule;

class PasswordRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['min:8'];
    }
}
