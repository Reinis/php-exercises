<?php

// FlowerShop
// List of flowers and prices
// Option to purchase
// First Question: male/female
// if female -> apply 20% discount at the end
// 3 different warehouses where flowers come
// Flowershop 1 -> Warehouse 1/2/3

// Warehouse 1 -> Flower('Tulip', 200)

declare(strict_types=1);

namespace FlowerShop;

require_once 'Flower.php';
require_once 'Flowers.php';
require_once 'WarehouseInterface.php';
require_once 'Warehouse.php';
require_once 'Warehouse1.php';
require_once 'Warehouse2.php';
require_once 'Warehouse3.php';
require_once 'FlowerShop.php';


$flowers1 = new Flowers(
    new Flower('Tulips', 200),
    new Flower('Roses', 230),
    new Flower('Magnolias', 160)
);
$flowers2 = new Flowers(
    new Flower('Tulips', 150),
    new Flower('Roses', 300)
);
$flowers3 = new Flowers(
    new Flower('Roses', 120),
    new Flower('Lilies', 140)
);

$flowersForSale = new Flowers(
    new Flower('Tulips', 300),
    new Flower('Roses', 500),
    new Flower('Lilies', 100)
);

$prices = [
    'Tulips' => 2,
    'Roses' => 5,
    'Lilies' => 7,
];

$warehouse1 = new Warehouse1('Warehouse1', $flowers1);
$warehouse2 = new Warehouse2('Warehouse2', $flowers2);
$warehouse3 = new Warehouse3('Warehouse3', $flowers3);

$shop = new FlowerShop($warehouse1, $warehouse2, $warehouse3);

echo "Stocking up the shop...\n";
echo $shop->stockFlowers($flowersForSale);

$shop->setPrices($prices);

// List flowers and prices
echo "\nInventory:\n";
echo $shop->list();
echo PHP_EOL;

do {
    $name = trim(readline('-> Choose flower type: '));
} while (!$shop->isAvailable($name));

do {
    echo "Available: {$shop->numAvailable($name)}\n";
    $amount = filter_var(readline('-> Choose amount: '), FILTER_VALIDATE_INT);
} while ($amount === false || $amount < 1 || $amount > $shop->numAvailable($name));

do {
    $customerGender = trim(readline('-> male/female? '));
} while ($customerGender !== 'male' && $customerGender !== 'female');

echo $shop->buyFlowers($name, $amount, $customerGender);
