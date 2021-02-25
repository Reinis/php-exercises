<?php

declare(strict_types=1);

namespace PhoneKeyPad;

// On your phone keypad, the alphabets are mapped to digits as follows:
// ABC(2), DEF(3), GHI(4), JKL(5), MNO(6), PQRS(7), TUV(8), WXYZ(9).
//
// Write a program called PhoneKeyPad, which prompts user for a String (case
// insensitive), and converts to a sequence of keypad digits.
//
// Use:
//
//    a "nested-if" statement
//    a "switch-case-default" statement
//
// Hint: In switch-case, you can handle multiple cases by omitting the break
// statement, e.g.,

class PhoneKeyPad
{
    private array $keyMap = [
        2 => 'ABC',
        3 => 'DEF',
        4 => 'GHI',
        5 => 'JKL',
        6 => 'MNO',
        7 => 'PQRS',
        8 => 'TUV',
        9 => 'WXYZ',
    ];

    private array $letterMap = [
        'A' => 2, 'B' => 2, 'C' => 2,
        'D' => 3, 'E' => 3, 'F' => 3,
        'G' => 4, 'H' => 4, 'I' => 4,
        'J' => 5, 'K' => 5, 'L' => 5,
        'M' => 6, 'N' => 6, 'O' => 6,
        'P' => 7, 'Q' => 7, 'R' => 7, 'S' => 7,
        'T' => 8, 'U' => 8, 'V' => 8,
        'W' => 9, 'X' => 9, 'Y' => 9, 'Z' => 9,
    ];

    public function getNumbers(string $input): string
    {
        $result = '';

        foreach (str_split($input) as $letter) {
            if (!isset($this->letterMap[$letter])) {
                $result .= ' ';
                continue;
            }

            $number = $this->letterMap[$letter];
            $repeats = strpos($this->keyMap[$number], $letter) + 1;

            for ($i = 0; $i < $repeats; $i++) {
                $result .= $number;
            }
        }

        return $result;
    }
}


$program = new PhoneKeyPad();

$input = strtoupper(readline('-> Enter a string: '));

echo $program->getNumbers($input);
echo PHP_EOL;
