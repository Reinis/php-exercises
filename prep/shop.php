<?php

// List of products
$productList = [
    [
        'name' => 'Salmiakki',
        'price' => 3
    ], [
        'name' => 'Geisha',
        'price' => 9
    ], [
        'name' => 'Dumle',
        'price' => 11
    ], [
        'name' => 'Marianne',
        'price' => 7
    ], [
        'name' => 'Sisu',
        'price' => 15
    ]
];

// Convert to objects
$products = [];

foreach ($productList as $product) {
    $products[] = (object)$product;
}

// Print the list of products with prices
$currentLocale = locale_get_default();

$fmt = numfmt_create($currentLocale, NumberFormatter::CURRENCY);

foreach ($products as $index => $product) {
    echo "{$index}. {$product->name} "
        . $fmt->formatCurrency($product->price, 'EUR')
        . PHP_EOL;
}

echo PHP_EOL;

// Select product
// Select amount
$lastIndex = count($products) - 1;

$what = readline("-> Select product [0–{$lastIndex}]: ");
$amount = readline("-> Amount? ");

if (!ctype_digit($what) or !ctype_digit($amount)) {
    echo 'Error: Expected an integer!' . PHP_EOL;
    exit(1);
}

$what = (int)$what;
$amount = (int)$amount;

if (0 > $what || $what > $lastIndex) {
    echo 'Invalid product selection!' . PHP_EOL;
    exit(2);
}

if ($amount <= 0) {
    echo 'Invalid product amount selected!' . PHP_EOL;
    exit(3);
}

// Print the invoice
echo "---------------------------------------------\n";

$total = $products[$what]->price * $amount;

echo 'Your order is to buy '
    . $amount
    . ' '
    . $products[$what]->name
    . '. Price: '
    . $fmt->formatCurrency($total, 'EUR')
    . PHP_EOL;
