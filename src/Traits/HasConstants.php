<?php

namespace Bakle\Translator\Traits;

trait HasConstants
{
    public static function getConstantsValues(): array
    {
        return array_values((new \ReflectionClass(self::class))->getConstants());
    }
}
