<?php

$moves = [
    1 => '✊',
    2 => '✋',
    3 => '✌'
];

$play = random_int(1, 3);

echo <<<EOL
Make your move!
1 - rock
2 - paper
3 - scissors

EOL;

$move = readline('-> ');

echo $moves[$move] . ' x ' . $moves[$play] . PHP_EOL;

switch ($move) {
    case 1:
        if ($play === 1) {
            echo 'draw' . PHP_EOL;
        } elseif ($play === 2) {
            echo 'loose' . PHP_EOL;
        } elseif ($play === 3) {
            echo 'win' . PHP_EOL;
        }
        break;
    case 2:
        if ($play === 2) {
            echo 'draw' . PHP_EOL;
        } elseif ($play === 3) {
            echo 'loose' . PHP_EOL;
        } elseif ($play === 1) {
            echo 'win' . PHP_EOL;
        }
        break;
    case 3:
        if ($play === 3) {
            echo 'draw' . PHP_EOL;
        } elseif ($play === 1) {
            echo 'loose' . PHP_EOL;
        } elseif ($play === 2) {
            echo 'win' . PHP_EOL;
        }
        break;
}
