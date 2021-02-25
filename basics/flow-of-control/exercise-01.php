<?php

$firstNumber = filter_var(readline("Input the 1st number: "), FILTER_VALIDATE_FLOAT);
$secondNumber = filter_var(readline("Input the 2nd number: "), FILTER_VALIDATE_FLOAT);
$thirdNumber = filter_var(readline("Input the 3rd number: "), FILTER_VALIDATE_FLOAT);

//todo print the largest number
$largest = $firstNumber;

if ($secondNumber > $largest) {
    $largest = $secondNumber;
}

if ($thirdNumber > $largest) {
    $largest = $thirdNumber;
}

echo $largest . PHP_EOL;
