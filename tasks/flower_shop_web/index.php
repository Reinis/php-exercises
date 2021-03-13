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


$style = <<<EOS
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
EOS;

$orderForm = <<<EOT
<div>
    <br>
    <form action="/?order=true">
        <label for="name">Flowers:</label>
        <input type="text" id="name" name="name"><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" min="1"><br>
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

echo $style;
echo "<div>Stocking up the shop...<br></div>\n";
$messages = $shop->stockFlowers($flowersForSale);
foreach ($messages as $message) {
    printf("<div>%s</div>", $message);
}
echo "<hr>";

$shop->setPrices($prices);

// List flowers and prices
echo "<h3>Inventory:</h3>\n";
echo $shop->listWeb();
echo PHP_EOL;
echo $orderForm;

if (!isset($_GET['name'])) {
    die();
}

$name = $_GET['name'] ?? "Roses";

if (!$shop->isAvailable($name)) {
    echo "<strong>Flower not found:</strong> {$name}<br><br>";
    echo "<a href='/'><button>Back</button></a>";
    die();
}

$amount = (int)($_GET['amount'] ?? 5);

if ($amount < 1 || $amount > $shop->numAvailable($name)) {
    echo "<strong>Invalid amount:</strong> {$amount}<br><br>";
    echo "<a href='/'><button>Back</button></a>";
    die();
}

$customerGender = $_GET['gender'] ?? 'female';

if ($customerGender !== 'male' && $customerGender !== 'female') {
    echo "<strong>Invalid gender:</strong> {$customerGender}<br><br>";
    echo "<a href='/'><button>Back</button></a>";
}

echo $shop->buyFlowersWeb($name, $amount, $customerGender) . PHP_EOL;
