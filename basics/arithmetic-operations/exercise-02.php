<?php

// Write a program called CheckOddEven which prints "Odd Number" if the
// int variable “number” is odd, or “Even Number” otherwise. The program shall
// always print “bye!” before exiting.
while (true) {
    do {
        $number = readline('-> Integer (q to quit): ');

        if ($number === 'q') {
            echo 'bye!' . PHP_EOL;
            exit(0);
        }

        $number = filter_var($number, FILTER_VALIDATE_INT);
    } while ($number === false);

    $number = (int)$number;

    echo ($number % 2 === 0 ? 'Even' : 'Odd') . ' Number' . PHP_EOL;
}

