<?php

namespace Recipes;

use ReflectionClass;

abstract class Enum
{
    final public static function isValid(int $value): bool
    {
        return in_array($value, static::toArray(), true);
    }

    final public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
