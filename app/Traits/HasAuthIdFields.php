<?php

namespace App\Traits;

use Closure;
use Exception;

trait HasAuthIdFields
{
    public static $isAutoInjectAuthIdFieldsOn = true;

    public function save(array $options = array())
    {
        if (self::$isAutoInjectAuthIdFieldsOn) {
            if (!property_exists($this, 'authIdFields') or !is_array($this->authIdFields))
                throw new Exception('authIdFields array property must be defined in ' . get_class($this) . '.');

            foreach ($this->authIdFields as $field)
                $this->$field = auth()->id();
        }

        return parent::save($options);
    }

    public static function withoutAutoInjectAuthIdFields(Closure $callable)
    {
        self::$isAutoInjectAuthIdFieldsOn = false;
        $callable();
        self::$isAutoInjectAuthIdFieldsOn = true;
    }
}
