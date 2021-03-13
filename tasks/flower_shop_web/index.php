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

require_once 'vendor/autoload.php';

use FlowerShopWeb\Flower;
use FlowerShopWeb\Flowers;
use FlowerShopWeb\FlowerShop;
use FlowerShopWeb\Warehouse1;
use FlowerShopWeb\Warehouse2;
use FlowerShopWeb\Warehouse3;


$flowers1 = new Flowers(
    new Flower('Tulips', 200),
    new Flower('Roses', 230),
    new Flower('Magnolias', 160)
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
$warehouse2 = new Warehouse2('Warehouse2', 'Warehouse2.csv');
$warehouse3 = new Warehouse3('Warehouse3', 'Warehouse3.json');

$shop = new FlowerShop($warehouse1, $warehouse2, $warehouse3);

echo "<div>Stocking up the shop...<br></div>\n";
echo $shop->stockFlowers($flowersForSale);

$shop->setPrices($prices);

// List flowers and prices
echo "<div><br>Inventory:</div>\n";
echo $shop->listWeb();
echo PHP_EOL;

//do {
//    $name = trim(readline('-> Choose flower type: '));
//} while (!$shop->isAvailable($name));
$name = "Roses";
//do {
//    echo "Available: {$shop->numAvailable($name)}\n";
//    $amount = filter_var(readline('-> Choose amount: '), FILTER_VALIDATE_INT);
//} while ($amount === false || $amount < 1 || $amount > $shop->numAvailable($name));
$amount = 5;
//do {
//    $customerGender = trim(readline('-> male/female? '));
//} while ($customerGender !== 'male' && $customerGender !== 'female');
$customerGender = 'female';
//echo $shop->buyFlowers($name, $amount, $customerGender) . PHP_EOL;
echo $shop->buyFlowersWeb($name, $amount, $customerGender) . PHP_EOL;
