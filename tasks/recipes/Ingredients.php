<?php

namespace Recipes;

use ArrayIterator;
use IteratorAggregate;

class Ingredients implements IteratorAggregate
{
    /**
     * @var Ingredient[]
     */
    private array $ingredients = [];

    public function __construct(Ingredient ...$ingredients)
    {
        foreach ($ingredients as $ingredient) {
            $this->addIngredient($ingredient);
        }
    }

    public function addIngredient(Ingredient $ingredient): void
    {
        $this->ingredients[$ingredient->getName()] = $ingredient;
    }

    /**
     * @return Ingredient[]
     */
    public function toArray(): array
    {
        return $this->ingredients;
    }

    /**
     * @return ArrayIterator|Ingredient[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->ingredients);
    }
}
