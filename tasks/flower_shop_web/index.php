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


$header = <<<EOS
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Flower Shop</title>
    <style>
        form, label, input {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 250px;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

EOS;

$footer = <<<EOT
</body>
</html>

EOT;

$orderForm = <<<EOT
<div>
    <form action="/" method="post">
        <label for="name">Flowers:</label>
        <input type="text" id="name" name="name"><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" min="1"><br><br>
        <input type="radio" id="female" name="gender" value="female" checked>
        <label for="female">Female</label>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Male</label><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

EOT;

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

echo $header;
echo "<div>Stocking up the shop...</div>\n";
$messages = $shop->stockFlowers($flowersForSale);
foreach ($messages as $message) {
    printf("<div>%s</div>\n", $message);
}
echo "<hr>\n";

$shop->setPrices($prices);

// List flowers and prices
echo "<h3>Inventory:</h3>\n";
echo <<<EOT
<table>
    <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Price</th>
    </tr>

EOT;

$formatString = <<<EOT
    <tr>
        <td>%s</td>
        <td>%d</td>
        <td>%d</td>
    </tr>

EOT;

foreach ($shop->getInventory() as $flower) {
    printf($formatString, $flower['name'], $flower['amount'], $flower['price']);
}

echo "</table><br>\n";
echo $orderForm;

if (!isset($_POST['name'])) {
    die($footer);
}

$name = $_POST['name'] ?? "Unknown";

if (!$shop->isAvailable($name)) {
    echo "<strong>Flower not found:</strong> {$name}";
    die($footer);
}

$amount = (int)($_POST['amount'] ?? 0);

if ($amount < 1 || $amount > $shop->numAvailable($name)) {
    echo "<strong>Invalid amount:</strong> {$amount}";
    die($footer);
}

$customerGender = $_POST['gender'] ?? 'unknown';

if ($customerGender !== 'male' && $customerGender !== 'female') {
    echo "<strong>Invalid gender:</strong> {$customerGender}";
    die($footer);
}

$invoice = $shop->getInvoice($name, $amount, $customerGender);

echo "<h3>Invoice:</h3>\n<table>\n";
$formatString = <<<EOT
    <tr>
        <td><strong>%s</strong></td>
        <td>%s</td>
    </tr>

EOT;

foreach ($invoice as $key => $value) {
    printf($formatString, ucfirst($key), $value);
}

echo "</table>\n";
echo $footer;
