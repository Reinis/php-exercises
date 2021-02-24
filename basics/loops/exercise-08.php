<?php

declare(strict_types=1);

namespace NumberSquare;

// Write a console program in a class named NumberSquare that prompts the user
// for two integers, a min and a max, and prints the numbers in the range from
// min to max inclusive in a square pattern. Each line of the square consists
// of a wrapping sequence of integers increasing from min and max. The first
// line begins with min, the second line begins with min + 1, and so on. When
// the sequence in any line reaches max, it wraps around back to min. You may
// assume that min is less than or equal to max. Here is an example dialogue:
//
// Min? 1
// Max? 5
// 12345
// 23451
// 34512
// 45123
// 51234

class NumberSquare
{
    public function run(): void
    {
        do {
            $min = filter_var(readline('Min? '), FILTER_VALIDATE_INT);
        } while ($min === false);

        do {
            $max = filter_var(readline('Max? '), FILTER_VALIDATE_INT);
        } while ($max === false || $max <= $min);

        $sequence = range($min, $max);

        for ($i = 0; $i < count($sequence); $i++) {
            echo implode($sequence) . PHP_EOL;
            array_push($sequence, array_shift($sequence));
        }
    }
}

$program = new NumberSquare();
$program->run();
