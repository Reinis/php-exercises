<?php

echo "===== Exercise 1\n";
// Create an array with integers (up to 10) and print them out using foreach loop.
$numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

foreach ($numbers as $number) {
    echo $number . ' ';
}

echo "\n";

echo "\n===== Exercise 2\n";
// Create an array with integers (up to 10) and print them out using for loop.

for ($i = 0; $i < count($numbers); $i++) {
    echo $numbers[$i] . ' ';
}

echo "\n";

echo "\n===== Exercise 3\n";
// Given variable $x = 1 while $x is lower than 10, print out text "codelex".
// (Note: To avoid infinite looping, after each print increase the variable $x by 1)
$x = 1;

while ($x < 10) {
    echo "codelex";
    $x++;
}

echo "\n";

echo "\n===== Exercise 4\n";
// Create a non associative array with integers and print out only integers
// that divides by 3 without any left.
$numbers = [2, 4, 5, 6, 9, 13, 14, 21, 47, 57];

foreach ($numbers as $number) {
    if ($number % 3 === 0) {
        echo $number . ' ';
    }
}

echo "\n";

echo "\n===== Exercise 5\n";
// Create an associative array with objects of multiple persons.
// Each person should have a name, surname, age and birthday. Using loop
// (by your choice) print out every persons personal data.
$peopleList = [
    'person1' => [
        'name' => 'John',
        'surname' => 'Doe',
        'birthday' => '1980-03-17',
        'age' => 40
    ],
    'person2' => [
        'name' => 'Jane',
        'surname' => 'Doe',
        'birthday' => '1985-07-21',
        'age' => 35
    ],
    'person3' => [
        'name' => 'Joe',
        'surname' => 'Ordinary',
        'birthday' => '1990-09-04',
        'age' => 30
    ]
];

$people = [];

foreach ($peopleList as $key => $value) {
    $people[$key] = (object) $value;
}

foreach ($people as $person) {
    echo "{$person->name} {$person->surname} {$person->birthday} ({$person->age})\n";
}
