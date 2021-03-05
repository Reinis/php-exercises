<?php

namespace Recipes;

class Recipe
{
    private Ingredients $ingredients;
    private string $name;

    public function __construct(string $name, Ingredient ...$ingredients)
    {
        $this->ingredients = new Ingredients(...$ingredients);
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMissingIngredients(Ingredients $products): Ingredients
    {
        $productNames = array_map(
            static fn(Ingredient $product): string => $product->getName(),
            $products->toArray()
        );

        return new Ingredients(
            ...array_filter(
                $this->getIngredients()->toArray(),
                static fn(Ingredient $ingredient): bool => !in_array($ingredient->getName(), $productNames, true)
            )
        );
    }

    public function getIngredients(): Ingredients
    {
        return $this->ingredients;
    }

    public function requires(Ingredient $ingredient): bool
    {
        foreach ($this->ingredients as $recipeIngredient) {
            if ($ingredient->getName() === $recipeIngredient->getName()) {
                return true;
            }
        }

        return false;
    }
}
