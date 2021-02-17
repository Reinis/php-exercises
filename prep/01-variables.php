<?php

// Create variable that prints out an integer 10, float 10.10, string "hello world"
echo "===== Exercise 1\n";
$i = 10;
$f = 10.10;
$s = "hello world";

echo "{$i}\n";
echo number_format($f, 2, '.', '') . "\n";
echo "{$s}\n";

// Dump the same values that should display both data type & its value.
// (Note, usage of var_dump)
echo "\n===== Exercise 2\n";
var_dump($i, $f, $s);

// Concatenate your name, surname and integer of your age.
echo "\n===== Exercise 3\n";
$t = new stdClass();
$t->name = 'Reinis';
$t->surname = 'Danne';
$t->age = 360;

echo "{$t->name} {$t->surname} {$t->age}\n";
