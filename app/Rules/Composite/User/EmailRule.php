<?php

namespace App\Rules\Composite\User;

use Illuminate\Contracts\Validation\Factory;
use Illuminatech\Validation\Composite\CompositeRule;

class EmailRule extends CompositeRule
{
    protected $excludeId;

    public function __construct($excludeId = null, ?Factory $validatorFactory = null)
    {
        parent::__construct($validatorFactory);
        $this->excludeId = $excludeId;
    }

    protected function rules(): array
    {
        return ['bail', 'email', 'unique:users,email' . ($this->excludeId ? ",{$this->excludeId}" : '')];
    }
}
