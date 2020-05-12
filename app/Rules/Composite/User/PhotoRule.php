<?php

namespace App\Rules\Composite\User;

use Illuminatech\Validation\Composite\CompositeRule;

class PhotoRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['image', 'max:5120'];
    }
}
