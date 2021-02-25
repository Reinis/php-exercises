<?php

/**
 * On your phone keypad, the alphabets are mapped to digits as follows:
 * ABC(2), DEF(3), GHI(4), JKL(5), MNO(6), PQRS(7), TUV(8), WXYZ(9).
 *
 * Write a program called PhoneKeyPad, which prompts user for a String (case
 * insensitive), and converts to a sequence of keypad digits.
 *
 * Use:
 *
 *   a "nested-if" statement
 *   a "switch-case-default" statement
 *
 * Hint: In switch-case, you can handle multiple cases by omitting the break
 * statement, e.g.,
 */

declare(strict_types=1);


namespace PhoneKeyPad;


class PhoneKeyPad
{
    public function getNumbers(string $input): string
    {
        $result = '';

        foreach (mb_str_split($input) as $letter) {
            switch ($letter) {
                case 'C':
                    $result .= '2';
                // no break
                case 'B':
                    $result .= '2';
                // no break
                case 'A':
                    $result .= '2';
                    break;
                case 'F':
                    $result .= '3';
                // no break
                case 'E':
                    $result .= '3';
                // no break
                case 'D':
                    $result .= '3';
                    break;
                case 'I':
                    $result .= '4';
                // no break
                case 'H':
                    $result .= '4';
                // no break
                case 'G':
                    $result .= '4';
                    break;
                case 'L':
                    $result .= '5';
                // no break
                case 'K':
                    $result .= '5';
                // no break
                case 'J':
                    $result .= '5';
                    break;
                case 'O':
                    $result .= '6';
                // no break
                case 'N':
                    $result .= '6';
                // no break
                case 'M':
                    $result .= '6';
                    break;
                case 'S':
                    $result .= '7';
                // no break
                case 'R':
                    $result .= '7';
                // no break
                case 'Q':
                    $result .= '7';
                // no break
                case 'P':
                    $result .= '7';
                    break;
                case 'V':
                    $result .= '8';
                // no break
                case 'U':
                    $result .= '8';
                // no break
                case 'T':
                    $result .= '8';
                    break;
                case 'Z':
                    $result .= '9';
                // no break
                case 'Y':
                    $result .= '9';
                // no break
                case 'X':
                    $result .= '9';
                // no break
                case 'W':
                    $result .= '9';
                    break;
                default:
                    $result .= ' ';
                    break;
            }
        }

        return $result;
    }
}


$program = new PhoneKeyPad();

while (true) {
    $input = strtoupper(readline('-> Enter a string: '));

    if (ctype_digit($input)) {
        $answer = strtoupper(readline('-> Quit? [Y/n] '));

        if ($answer === '' || $answer === 'Y') {
            break;
        }

        continue;
    }

    echo $program->getNumbers($input);
    echo PHP_EOL;
}
