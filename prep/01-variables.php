<?php

// Create variable that prints out an integer 10, float 10.10, string "hello world"
echo "===== Exercise 1\n";
$wholeNumber = 10;
$decimalNumber = 10.10;
$text = "hello world";

echo "{$wholeNumber}\n";
echo number_format($decimalNumber, 2, '.', '') . PHP_EOL;
echo "{$text}\n";

// Dump the same values that should display both data type & its value.
// (Note, usage of var_dump)
echo "\n===== Exercise 2\n";
var_dump($wholeNumber, $decimalNumber, $text);

// Concatenate your name, surname and integer of your age.
echo "\n===== Exercise 3\n";
$person = new stdClass();
$person->name = 'Reinis';
$person->surname = 'Danne';
$person->age = 360;

echo "{$person->name} {$person->surname} {$person->age}\n";
