<?php

namespace SlotMachine;

class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;
    public const NUMBER_OF_SLOTS = 3;
    public const PLACEHOLDER_ELEMENT = '🧺';

    private const REWARD_FACTOR = 10;

    private array $elements = [
        '⭐' => 0,
        '🍎' => 5,
        '🍍' => 10,
        '🍇' => 15,
        '🍉' => 20,
        '🍒' => 25,
    ];
    private array $elementCounts = [10, 0, 5, 3, 1, 1];
    private array $elementsExpanded = [];
    private array $elementsBonus;
    private int $prize = 0;
    private int $bonus = 0;
    private array $rolls = [];
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;

        // Control the chance of rolling a given element
        $repeats = array_combine(array_keys($this->elements), $this->elementCounts);

        foreach ($repeats as $element => $number) {
            $this->elementsExpanded = array_merge(
                $this->elementsExpanded,
                array_fill(0, $number, $element)
            );
        }

        // Lower the chance to win another bonus in a bonus game
        $this->elementsBonus = array_filter(
            $this->elementsExpanded,
            fn($element) => $element !== array_key_first($this->elements)
        );
        $this->elementsBonus[] = array_key_first($this->elements);
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
            return $this->elementsBonus[array_rand($this->elementsBonus)];
        }

        return $this->elementsExpanded[array_rand($this->elementsExpanded)];
    }

    private function addPrize(int $prize): void
    {
        $this->prize += $prize * $this->player->getBet() / self::REWARD_FACTOR;
        $this->player->reward($this->prize);
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
