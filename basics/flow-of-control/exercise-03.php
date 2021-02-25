<?php

// Write a program that reads an positive integer and count the number of
// digits the number has.

do {
    $number = filter_var(readline('Integer (positive): '), FILTER_VALIDATE_INT);
} while ($number === false || $number < 0);

$number = (string)$number;

echo "Number {$number} has " . count(str_split($number)) . " digits.\n";
