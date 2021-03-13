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
use FlowerShopWeb\View;
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
$view = new View();

$messages = $shop->stockFlowers($flowersForSale);
$shop->setPrices($prices);
$inventory = $shop->getInventory();

echo $view->getHeader();
echo $view->getStockingMessages(...$messages);
echo $view->getInventoryTable($inventory);
echo $view->getOrderForm($inventory);

if (!isset($_POST['name'])) {
    die($view->getFooter());
}

$name = $_POST['name'] ?? "Unknown";

if (!$shop->isAvailable($name)) {
    echo $view->getInvalidNameMsg($name);
    die($view->getFooter());
}

$amount = (int)($_POST['amount'] ?? 0);

if ($amount < 1 || $amount > $shop->numAvailable($name)) {
    echo $view->getInvalidAmountMsg($amount);
    die($view->getFooter());
}

$customerGender = $_POST['gender'] ?? 'unknown';

if ($customerGender !== 'male' && $customerGender !== 'female') {
    echo $view->getInvalidGenderMsg($customerGender);
    die($view->getFooter());
}

$invoice = $shop->getInvoice($name, $amount, $customerGender);

echo $view->getInvoiceTable($invoice);
echo $view->getFooter();
