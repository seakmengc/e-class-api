<?php

namespace App\Traits;

use Exception;

trait HasAuthIdFields
{
    public function save(array $options = array())
    {
        if (!property_exists($this, 'authIdFields') or !is_array($this->authIdFields))
            throw new Exception('authIdFields property must be defined in ' . get_class($this) . '.');

        foreach ($this->authIdFields as $field)
            $this->$field = auth()->id();

        parent::save($options);
    }
}
