<?php

// Write a program to accept two integers and return true if the either one
// is 15 or if their sum or difference is 15.
$usage = 'usage: php exercise-01.php number1 number2' . PHP_EOL;

if (!empty($argv[1]) and !empty($argv[2])) {
    $x = $argv[1];
    $y = $argv[2];
} else {
    die($usage);
}

if ($x == 15 or $y == 15 or abs($x - $y) === 15) {
    echo 'true';
} else {
    echo 'false';
}
echo PHP_EOL;
