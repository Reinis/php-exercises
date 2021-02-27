<?php


namespace SlotMachine;


class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;
    public const NUMBER_OF_SLOTS = 3;

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

    public function init(): void
    {
        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            printf("%s %s %s\n", '🧺', '🧺', '🧺');
        }

        printf(
            "Prize: %4d bonus: %4d available: %4d\n",
            $this->prize,
            $this->bonus,
            $this->player->getAmount()
        );
    }

    public function play(bool $bonusGame = false): array
    {
        $rolls = [];

        if ($bonusGame && $this->bonus > 0) {
            $this->bonus--;
        }

        for ($i = 0; $i < self::NUMBER_OF_SLOTS; $i++) {
            $rolls[] = [];

            for ($j = 0; $j < self::NUMBER_OF_SLOTS; $j++) {
                $rolls[$i][] = $this->roll($bonusGame);
            }
        }

        // Check for win
        $this->prize = 0;
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

        return $rolls;
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
}
