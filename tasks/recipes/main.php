<?php

// X: 2
// tomato
// cucumber

// Recipe - tomato, eggs, cucumber, banana / TurboSalad
// Recipe - tomato, nuts / NotTurboSalad

// With tomato I can make TurboSalad, NotTurboSalad
// TurboSalad: Missing: eggs, banana
// NotTurboSalad: Missing: nuts

declare(strict_types=1);

namespace Recipes;

require_once 'Enum.php';
require_once 'Ingredient.php';
require_once 'Ingredients.php';

require_once 'Recipe.php';
require_once 'Recipes.php';


$tomato = new Ingredient(Ingredient::TOMATO);
$cucumber = new Ingredient(Ingredient::CUCUMBER);
$egg = new Ingredient(Ingredient::EGG);
$banana = new Ingredient(Ingredient::BANANA);
$nuts = new Ingredient(Ingredient::NUTS);

$ingredientList = Ingredient::all()->toArray();

$recipeList = [
    new Recipe("TurboSalad", $tomato, $egg, $cucumber, $banana),
    new Recipe("NotTurboSalad", $tomato, $nuts),
];

$recipes = new Recipes(...$recipeList);


// Build the list of available products
$productList = new Ingredients();

$products = implode("\n", $ingredientList);
echo <<<EOT
Available products:
{$products}

Enter number of products and the name of the product on each line:

EOT;

[$productCount] = fscanf(STDIN, "%d");

if ($productCount === false || $productCount === null) {
    echo "Error: Invalid number!\n";
    echo <<<EOT
    Usage:
    $ php main.php
    N
    product1
    ...
    productN

    EOT;
}

for ($i = 0; $i < $productCount; $i++) {
    fscanf(STDIN, "%s", $product);

    if (isset($ingredientList[$product])) {
        $productList->addIngredient($ingredientList[$product]);
    } else {
        echo "Unknown ingredient: {$product}\n";
    }
}


// Print matching recipes with the missing ingredients
foreach ($productList as $product) {
    echo PHP_EOL;
    echo "With {$product} one can make:\n";

    foreach ($recipes->getRecipesByIngredient($product) as $recipe) {
        echo "{$recipe->getName()}\n";
        echo "    Missing: ";
        echo implode(
            ', ',
            $recipe->getMissingIngredients($productList)->toArray()
        );
        echo PHP_EOL;
    }
}
