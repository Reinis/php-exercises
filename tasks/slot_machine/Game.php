<?php

namespace SlotMachine;

class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;
    public const NUMBER_OF_SLOTS = 3;
    public const PLACEHOLDER_ELEMENT = '🧺';

    private const REWARD_FACTOR = 10;

    private Element $bonusElement;
    private array $elements;
    private array $elementsExpanded;
    private array $elementsBonus;
    private int $prize = 0;
    private int $bonus = 0;
    private array $rolls = [];
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->bonusElement = new Element('⭐', 0, 10);
        $this->elements = [
            $this->bonusElement,
            new Element('🍎', 5, 0),
            new Element('🍍', 10, 5),
            new Element('🍇', 15, 3),
            new Element('🍉', 20, 1),
            new Element('🍒', 25, 1),
        ];

        // Control the chance of rolling a given element
        $this->elementsExpanded = array_merge(
            ...array_map(
                static fn(Element $element): array => $element->repeat(),
                $this->elements
            )
        );

        // Lower the chance to win another bonus in a bonus game
        $this->elementsBonus = array_filter(
            $this->elementsExpanded,
            fn(Element $element): bool => $element !== $this->bonusElement
        );
        $this->elementsBonus[] = $this->bonusElement;
    }

    public function play(bool $bonusGame = false): void
    {
        $rolls = [];
        $this->prize = 0;

        if ($bonusGame && $this->bonus > 0) {
            $this->bonus--;
        }

        // Get rows of random elements
        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            $rolls[] = [];

            for ($j = 0; $j < self::NUMBER_OF_SLOTS; $j++) {
                $rolls[$i][] = $this->roll($bonusGame);
            }
        }

        $this->rolls = $rolls;

        // Construct diagonals
        $diagonals = [[], []];

        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            $diagonals[0][] = $rolls[$i][$i];
            $diagonals[1][] = $rolls[$i][self::NUMBER_OF_SLOTS - $i - 1];
        }

        // Store all lines in one array
        $lines = array_merge($rolls, $diagonals);

        // Check for win
        foreach ($lines as $line) {
            if (count(array_unique($line)) === 1) {
                if (end($line) === $this->bonusElement) {
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
            return $this->elementsBonus[array_rand($this->elementsBonus)];
        }

        return $this->elementsExpanded[array_rand($this->elementsExpanded)];
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
