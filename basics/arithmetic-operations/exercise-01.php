<?php

// Write a program to accept two integers and return true if the either one
// is 15 or if their sum or difference is 15.
do {
    $x = filter_var(readline('-> First integer: '), FILTER_VALIDATE_INT);
} while ($x === false);

do {
    $y = filter_var(readline('-> Second integer: '), FILTER_VALIDATE_INT);
} while ($y === false);

$x = (int)$x;
$y = (int)$y;

if ($x === 15
    or $y === 15
    or $x + $y === 15
    or abs($x - $y) === 15) {
    echo 'true';
} else {
    echo 'false';
}
echo PHP_EOL;
