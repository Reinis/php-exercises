<?php

// Write a program to accept two integers and return true if the either one
// is 15 or if their sum or difference is 15.
$x = readline('-> First integer: ');
$y = readline('-> Second integer: ');

if ($x == 15 or $y == 15 or abs($x - $y) === 15) {
    echo 'true';
} else {
    echo 'false';
}
echo PHP_EOL;
