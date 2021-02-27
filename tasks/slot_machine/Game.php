<?php

namespace SlotMachine;

class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;
    public const NUMBER_OF_SLOTS = 3;
    public const PLACEHOLDER_ELEMENT = '🧺';

    private array $elements = [
        '⭐' => 0,
        '🍎' => 15,
        '🍍' => 15,
        '🍇' => 15,
        '🍉' => 20,
        '🍒' => 25,
    ];
    private array $elementsExpanded;
    private array $elementsUnique;
    private int $prize = 0;
    private int $bonus = 0;
    private array $rolls = [];
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;

        $star = [];
        for ($i = 0; $i < 5; $i++) {
            $star[] = '⭐';
        }

        $elements = ['🍎', '🍍', '🍇', '🍉', '🍒'];
        $this->elementsExpanded = array_merge($elements, $star);
        $this->elementsUnique = array_unique($this->elementsExpanded);
    }

    public function play(bool $bonusGame = false): void
    {
        $rolls = [];
        $this->prize = 0;

        if ($bonusGame && $this->bonus > 0) {
            $this->bonus--;
        }

        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            $rolls[] = [];

            for ($j = 0; $j < self::NUMBER_OF_SLOTS; $j++) {
                $rolls[$i][] = $this->roll($bonusGame);
            }
        }

        $this->rolls = $rolls;

        // Check for win
        foreach ($rolls as $roll) {
            if (count(array_unique($roll)) === 1) {
                if (end($roll) === array_key_first($this->elements)) {
                    $this->bonus += self::NUMBER_OF_BONUS_GAMES;
                    continue;
                }

                $this->addPrize($this->elements[end($roll)]);
            }
        }

        $diagonals = [[], []];

        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            $diagonals[0][] = $rolls[$i][$i];
            $diagonals[1][] = $rolls[$i][self::NUMBER_OF_SLOTS - $i - 1];
        }

        foreach ($diagonals as $diagonal) {
            if (count(array_unique($diagonal)) === 1) {
                if (end($diagonal) === array_key_first($this->elements)) {
                    $this->bonus += self::NUMBER_OF_BONUS_GAMES;
                    continue;
                }

                $this->addPrize($this->elements[end($diagonal)]);
            }
        }
    }

    private function roll(bool $bonusGame = false): string
    {
        if ($bonusGame) {
            return $this->elementsUnique[array_rand($this->elementsUnique)];
        }

        return $this->elementsExpanded[array_rand($this->elementsExpanded)];
    }

    private function addPrize(int $prize): void
    {
        $this->prize += $prize;
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
}
