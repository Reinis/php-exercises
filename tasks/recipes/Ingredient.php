<?php

namespace Recipes;

use InvalidArgumentException;

class Ingredient extends Enum
{
    public const TOMATO = 1;
    public const CUCUMBER = 2;
    public const EGG = 3;
    public const BANANA = 4;
    public const NUTS = 5;

    protected string $name = 'ingredient';

    public function __construct(int $type)
    {
        if (!static::isValid($type)) {
            throw new InvalidArgumentException("Invalid ingredient {$type}.");
        }

        $this->name = strtolower(array_flip(static::toArray())[$type]);
    }

    public static function all(): Ingredients
    {
        $ingredientList = [];

        foreach (static::toArray() as $type) {
            $ingredientList[] = new Ingredient($type);
        }

        return new Ingredients(...$ingredientList);
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
