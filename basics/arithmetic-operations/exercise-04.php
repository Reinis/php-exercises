<?php

// Write a program to compute the product of integers from 1 to 10
// (i.e., 1×2×3×...×10), as an int. Take note that it is the same as
// factorial of N.
$start = 1;
$end = 10;

$product = 1;

while ($start <= $end) {
    $product *= $start;
    $start++;
};

echo "{$end}! = " . $product . PHP_EOL;
