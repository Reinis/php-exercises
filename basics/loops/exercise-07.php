<?php

declare(strict_types=1);

namespace RollTwoDice;

// Write a console program in a class named RollTwoDice that prompts the user
// for a desired sum, then repeatedly rolls two six-sided dice (using a Random
// object to generate random numbers from 1-6) until the sum of the two dice
// values is the desired sum. Here is the expected dialogue with the user:
//
// Desired sum: 9
// 4 and 3 = 7
// 3 and 5 = 8
// 5 and 6 = 11
// 5 and 6 = 11
// 1 and 5 = 6
// 6 and 3 = 9

const DICE_SIZE = 6;

class Random
{
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getRand(): int
    {
        return rand($this->start, $this->end);
    }
}

class RollTwoDice
{
    private Random $randGenerator;
    private int $diceSize;

    public function __construct(Random $randGenerator, int $diceSize)
    {
        $this->randGenerator = $randGenerator;
        $this->diceSize = $diceSize;
    }

    public function run(): void
    {
        do {
            $number = filter_var(
                readline('Desired sum: '),
                FILTER_VALIDATE_INT
            );
        } while ($number === false || $number < 2 || $number > 2 * $this->diceSize);

        do {
            $firstRoll = $this->randGenerator->getRand();
            $secondRoll = $this->randGenerator->getRand();

            $sum = $firstRoll + $secondRoll;

            echo "{$firstRoll} and {$secondRoll} = {$sum}\n";
        } while ($sum !== $number);
    }
}

$random = new Random(1, DICE_SIZE);
$game = new RollTwoDice($random, DICE_SIZE);
$game->run();
