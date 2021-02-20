<?php

$moves = [
    0 => '✊',
    1 => '✋',
    2 => '✌'
];

$play = array_rand($moves);

echo <<<EOL
Make your move!
0 - rock
1 - paper
2 - scissors

EOL;

$move = (int)readline('-> ');

if (!in_array($move, array_keys($moves))) {
    echo 'Invalid move!' . PHP_EOL;
    exit(1);
}

echo $moves[$move] . ' x ' . $moves[$play] . PHP_EOL;

if ($move === $play) {
    echo 'draw';
} elseif (array_keys($moves)[($move + 1) % 3] === $play) {
    echo 'loose';
} else {
    echo 'win';
}
echo PHP_EOL;
