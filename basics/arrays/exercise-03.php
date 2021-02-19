<?php

$numbers = [
    1789, 2035, 1899, 1456, 2013,
    1458, 2458, 1254, 1472, 2365,
    1456, 2265, 1457, 2456
];

$number = readline("Enter the value to search for: ");

if (!ctype_digit($number)) {
    echo 'Error: Invalid input! Expected integer, but got: ' . $number . PHP_EOL;
    exit(1);
}

$number = (int)$number;

//todo check if an array contains a value user entered
if (in_array($number, $numbers)) {
    echo "The array does have number {$number}!\n";
} else {
    echo "The array does not have number {$number}!\n";
}
