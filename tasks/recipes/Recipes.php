<?php

namespace Recipes;

use ArrayIterator;
use IteratorAggregate;

class Recipes implements IteratorAggregate
{
    /**
     * @var Recipe[]
     */
    private array $recipes = [];

    public function __construct(Recipe ...$recipes)
    {
        foreach ($recipes as $recipe) {
            $this->addRecipe($recipe);
        }
    }

    public function addRecipe(Recipe $recipe): void
    {
        $this->recipes[$recipe->getName()] = $recipe;
    }

    public function getRecipesByIngredient(Ingredient $ingredient): Recipes
    {
        return new Recipes(
            ...array_filter(
                array_values($this->recipes),
                static fn(Recipe $recipe): bool => $recipe->requires($ingredient)
            )
        );
    }

    /**
     * @return ArrayIterator|Recipe[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->recipes);
    }
}
