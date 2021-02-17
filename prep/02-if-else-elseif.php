<?php

echo "===== Exercise 1\n";
// Given variables (int) 10, string "10" determine if they both are the same.
$number = 10;
$text = '10';

if ($number === $text) {
    echo 'Inputs are the same';
} else if ($number == $text) {
    echo 'Inputs are equal';
} else {
    echo 'Inputs are different';
}

echo "\n";

echo "\n===== Exercise 2\n";
// Given variable (int) 50, determine if its in the range of 1 and 100.
$number = 50;

if (1 <= $number && $number <= 100) {
    echo 'Number is in range [1; 100].';
} else {
    echo 'Number is out of range.';
}

echo "\n";

echo "\n===== Exercise 3\n";
// Given variables (string) "hello" create a condition that if the given value
// is "hello" then output "world".
$text = 'hello';

if ($text === 'hello') {
    echo 'world';
} else {
    echo ':(';
}

echo "\n";

echo "\n===== Exercise 4\n";
// By your choice, create condition with 3 checks.
// For example, if value is greater than X, less than Y and is an even number.

if (1 <= $number && $number <= 100 && $number % 2 === 0) {
    echo 'The even number is in range [1; 100].';
} else {
    echo 'Invalid number.';
}

echo "\n";

echo "\n===== Exercise 5\n";
// Given variable (int) 50 create a condition that prints out "correct" if the
// variable is inside the range.
// Range should be stored within the 2 separated variables $y and $z.
$number = 50;
$start = 1;
$end = 100;

if ($start <= $number && $number <= $end) {
    echo "correct\n";
}

echo "\n===== Exercise 6\n";
// Create a variable $plateNumber that stores your car plate number. Create
// a switch statement that prints out that its your car in case of your number.
$plateNumber = 'RD1234';

switch ($plateNumber) {
    case 'RD1234':
        echo 'My car!';
        break;
    default:
        echo 'Unknown car.';
        break;
}

echo "\n";

echo "\n===== Exercise 7\n";
// Create a variable $number with integer by your choice. Create a switch
// statement that prints out text "low" if the value is under 50, "medium"
// if the case is higher than 50 but lower than 100, "high" if the value
// is >100.
$number = 42;

switch (true) {
    case ($number < 50):
        echo 'low';
        break;
    case (50 <= $number && $number <= 100):
        echo 'medium';
        break;
    case ($number > 100):
        echo 'high';
        break;
    default:
        echo 'Invalid number!';
        break;
}

echo "\n";
