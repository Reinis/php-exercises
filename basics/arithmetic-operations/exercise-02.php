<?php

// Write a program called CheckOddEven which prints "Odd Number" if the
// int variable “number” is odd, or “Even Number” otherwise. The program shall
// always print “bye!” before exiting.
$number = readline('-> Integer: ');

echo ($number % 2 === 0 ? 'Even' : 'Odd') . ' Number' .  PHP_EOL;

echo 'bye!' . PHP_EOL;
