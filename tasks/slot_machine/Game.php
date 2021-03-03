<?php

namespace SlotMachine;

use Generator;
use InvalidArgumentException;

class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;
    public const NUMBER_OF_ROWS = 3;
    public const NUMBER_OF_COLUMNS = 3;
    public const PLACEHOLDER_ELEMENT = '🧺';

    private const REWARD_FACTOR = 10;

    private array $elementsExpanded;
    private array $elementsBonus;
    private int $prize = 0;
    private int $bonus = 0;
    private array $rolls = [];
    private Player $player;

    public function __construct(array $elements, Player $player)
    {
        $this->player = $player;

        // Control the chance of rolling a given element
        $this->setExpandedElements($elements);

        // Lower the chance to win another bonus in a bonus game
        $this->setBonusElements($elements);
    }

    private function setExpandedElements(array $elements): void
    {
        $this->elementsExpanded = array_merge(
            ...array_map(
                static fn(Element $element): array => $element->repeat(),
                $elements
            )
        );
    }

    private function setBonusElements(array $elements): void
    {
        $this->elementsBonus = [
            ...array_filter(
                $this->elementsExpanded,
                static fn(Element $element): bool => !$element->isBonus()
            ),
            ...array_filter(
                $elements,
                static fn(Element $element): bool => $element->isBonus()
            ),
        ];
    }

    public function play(bool $bonusGame = false): void
    {
        $rolls = [];
        $this->prize = 0;

        if ($bonusGame && $this->bonus > 0) {
            $this->bonus--;
        }

        // Get rows of random elements
        for ($i = 0; $i < self::NUMBER_OF_ROWS; $i++) {
            $rolls[] = [];

            for ($j = 0; $j < self::NUMBER_OF_COLUMNS; $j++) {
                $rolls[$i][] = $this->roll($bonusGame);
            }
        }

        $this->rolls = $rolls;

        $diagonals = $this->constructDiagonals($rolls);

        // Store all lines in one array
        $lines = array_merge($rolls, $diagonals);

        // Check for win
        foreach ($lines as $line) {
            if (count(array_unique($line)) === 1) {
                if (end($line)->isBonus()) {
                    $this->bonus += self::NUMBER_OF_BONUS_GAMES;
                    continue;
                }

                $this->addPrize(end($line)->getValue());
            }
        }
    }

    private function roll(bool $bonusGame = false): Element
    {
        if ($bonusGame) {
            return $this->elementsBonus[(int)array_rand($this->elementsBonus)];
        }

        return $this->elementsExpanded[(int)array_rand($this->elementsExpanded)];
    }

    private function constructDiagonals(array $rolls): array
    {
        $diagonals = [];

        for ($row = 0; $row < self::NUMBER_OF_ROWS; $row++) {
            if ($row !== self::NUMBER_OF_ROWS - 1) {
                $diagonals[] = $this->getDiagonal($row, $rolls, true);
            }
            if ($row !== 0) {
                $diagonals[] = $this->getDiagonal($row, $rolls, false);
            }
        }

        return $diagonals;
    }

    private function getDiagonal(int $row, array $rolls, bool $down): array
    {
        $diagonal = [];

        $seq = $this->generateDiagonalSequence($row, $down);

        for ($col = 0; $col < self::NUMBER_OF_COLUMNS; $col++) {
            $diagonal[] = $rolls[$seq->current()][$col];

            $seq->next();
        }

        return $diagonal;
    }

    private function generateDiagonalSequence(int $startRow, bool $down): Generator
    {
        if (!$down && $startRow === 0) {
            throw new InvalidArgumentException("No up diagonal for the first row.");
        }
        if ($down && $startRow === self::NUMBER_OF_ROWS - 1) {
            throw new InvalidArgumentException("No down diagonal for the last row.");
        }

        $row = $startRow;
        $directions = $down ? [1, -1] : [-1, 1];
        $cycleLength = self::NUMBER_OF_ROWS - 1;
        $sign = $down ? 1 : -1;

        for ($i = 0; $i < self::NUMBER_OF_COLUMNS; $i++) {
            yield $row;

            $shift = ($cycleLength + $startRow * $sign) % $cycleLength;
            $evenCycle = intdiv($i + $shift, $cycleLength) % 2 === 0;
            $row += $evenCycle ? $directions[0] : $directions[1];
        }
    }

    private function addPrize(int $prize): void
    {
        $prize *= $this->player->getBet() / self::REWARD_FACTOR;

        $this->prize += $prize;
        $this->player->reward($prize);
    }

    public function getBonus(): int
    {
        return $this->bonus;
    }

    public function getPrize(): int
    {
        return $this->prize;
    }

    public function getRolls(): array
    {
        return $this->rolls;
    }

    public function getAmount(): int
    {
        return $this->player->getAmount();
    }

    public function setAmount(int $amount): void
    {
        $this->player->setAmount($amount);
    }

    public function setBet(int $bet): void
    {
        $this->player->setBet($bet);
    }
}
