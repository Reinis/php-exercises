<?php

declare(strict_types=1);

// Coffee machine
// Money (coins): 1, 2, 5, 10, 20, 50, 100, 200
// -------
// Wallet: 1 - 10, 2 - 50
// Wallet total:
// Input: Price
//  Check if total amount is enough for the price
// ----------
// Latte - 150
// Black - 180
// White - 220
// -- input coins
// -- return coins
// -----------------
// Wallet: 1 - 10, 2 - 50
// Wallet total:

class MenuItem
{
    public string $name;
    public int $price;

    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

$menu = [
    new MenuItem('Latte', 150),
    new MenuItem('Black Coffee', 180),
    new MenuItem('Tea', 120),
];

$wallet = [
    1 => 10,
    2 => 15,
    5 => 8,
    10 => 12,
    20 => 4,
    50 => 3,
    100 => 5,
    200 => 2
];

function countMoney(array $wallet): int
{
    $sum = 0;

    foreach ($wallet as $key => $value) {
        $sum += $key * $value;
    }

    return $sum;
}

$moneyFormatter = numfmt_create('en_US', NumberFormatter::CURRENCY);
const CURRENCY = 'USD';


while (true) {
    // Print the wallet
    echo 'Wallet: ';
    echo implode(
        ', ',
        array_map(
            fn(int $nominal, int $number): string => "$nominal - $number",
            array_keys($wallet),
            $wallet
        )
    );
    echo PHP_EOL;

    echo 'Wallet total: ' . countMoney($wallet) . PHP_EOL;

    // Print the menu
    foreach ($menu as $index => $item) {
        echo "{$index}. {$item->name} - "
            . $moneyFormatter->formatCurrency($item->price / 100, CURRENCY)
            . PHP_EOL;
    }

    // Ask for an order
    do {
        $choice = filter_var(readline('-> Choose your coffee: '), FILTER_VALIDATE_INT);
    } while ($choice === false or !isset($menu[$choice]));

    $order = $menu[$choice];

    echo 'Your order: '
        . $order->name
        . ' - ' .
        $moneyFormatter->formatCurrency($order->price / 100, CURRENCY)
        . PHP_EOL;

    // Check if there is enough money in the wallet
    if ($order->price > countMoney($wallet)) {
        echo "You don't have enough money!\n";
        exit(1);
    }

    // Ask for the coins
    $total = 0;

    do {
        echo 'Total: ' . $total . PHP_EOL;
        $coins = preg_split('/[\s,]/', trim(readline('-> Insert the coins: ')));

        foreach ($coins as $coin) {
            $coin = filter_var($coin, FILTER_VALIDATE_INT);

            if ($coin === false) {
                continue;
            }

            if (isset($wallet[$coin]) and $wallet[$coin] > 0) {
                $total += $coin;
                $wallet[$coin]--;
            }
        }
    } while ($total < $order->price);

    // Give the order
    echo "Take your {$order->name}!\n";

    // Return the remainder
    if ($total !== $order->price) {
        echo 'Return:' . PHP_EOL;

        $reminder = $total - $order->price;

        foreach (array_reverse(array_keys($wallet)) as $coin) {
            if ($reminder < $coin) {
                continue;
            }

            $num = intdiv($reminder, $coin);

            echo "{$coin} - {$num}\n";

            $reminder -= $coin * $num;
            $wallet[$coin] += $num;

            if ($reminder === 0) {
                break;
            }
        }
    }

    echo PHP_EOL;
}
