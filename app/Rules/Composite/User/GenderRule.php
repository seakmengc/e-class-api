<?php

namespace App\Rules\Composite\User;

use Illuminatech\Validation\Composite\CompositeRule;

class GenderRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['in:male,female,others'];
    }
}
