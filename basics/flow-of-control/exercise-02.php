<?php

$number = filter_var(readline("Enter the number: "), FILTER_VALIDATE_FLOAT);

//todo print if number is positive or negative
if ($number === 0.0) {
    echo "That is a zero.\n";
    exit();
}

echo $number . ' is ' . ($number > 0 ? 'positive' : 'negative') . PHP_EOL;
