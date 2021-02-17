<?php

echo "===== Exercise 1\n";
// Create a non-associative array with 3 integer values and display the total sum of them.
$numbers = [23, 43, 56,];

echo array_sum($numbers) . "\n";

echo "\n===== Exercise 2\n";
// Using dump method, dump out all 3 values of the given array.
$person = [
    "name" => "John",
    "surname" => "Doe",
    "age" => 50
];

var_dump($person);

echo "\n===== Exercise 3\n";
// Using dump method, dump out all 3 values of the given object.
$person = new stdClass();
$person->name = "John";
$person->surname = "Doe";
$person->surname = 50;

var_dump($person);

echo "\n===== Exercise 4\n";
// Program should display concatenated value of - Jane Doe 41
$people = [
    [
        [
            "name" => "John",
            "surname" => "Doe",
            "age" => 50
        ],
        [
            "name" => "Jane",
            "surname" => "Doe",
            "age" => 41
        ]
    ]
];

echo "{$people[0][1]['name']} {$people[0][1]['surname']} {$people[0][1]['age']}\n";

echo "\n===== Exercise 5\n";
// Program should display concatenated value of - John & Jane Doe`s

echo "{$people[0][0]['name']} & {$people[0][1]['name']} {$people[0][1]['surname']}'s\n";
