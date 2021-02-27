<?php


namespace SlotMachine;


class Game
{
    public const NUMBER_OF_BONUS_GAMES = 5;

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
        for ($i = 0; $i < 3; $i++) {
            printf("%s %s %s\n", '🧺', '🧺', '🧺');
        }

        printf(
            "Prize: %4d bonus: %4d available: %4d\n",
            $this->prize,
            $this->bonus,
            $this->player->getAmount()
        );
    }

    public function play(bool $bonusGame = false): int
    {
        $rolls = [];

        if ($bonusGame && $this->bonus > 0) {
            $this->bonus--;
        }

        for ($i = 0; $i < 3; $i++) {
            $rolls[] = [];

            for ($j = 0; $j < 3; $j++) {
                $rolls[$i][] = $this->roll($bonusGame);
            }

            printf("%s %s %s\n", ...$rolls[$i]);
            sleep(1);
        }

        // Check for win
        $this->prize = 0;
        foreach ($rolls as $roll) {
            if (count(array_unique($roll)) === 1) {
                if (end($roll) === array_key_first($this->elements)) {
                    $this->bonus += 5;
                    continue;
                }

                // Add to prize
                $this->prize += $this->elements[end($roll)];
            }
        }

        $diagonals = [
            [$rolls[0][0], $rolls[1][1], $rolls[2][2]],
            [$rolls[0][2], $rolls[1][1], $rolls[2][0]]
        ];

        foreach ($diagonals as $diagonal) {
            if (count(array_unique($diagonal)) === 1) {
                if (end($roll) === array_key_first($this->elements)) {
                    $this->bonus += 5;
                    continue;
                }

                // Add to prize
                $this->prize += $this->elements[end($diagonal)];
            }
        }

        return $this->prize;
    }

    private function roll(bool $bonusGame = false): string
    {
        if ($bonusGame) {
            return $this->elementsUnique[array_rand($this->elementsUnique)];
        }

        return $this->elementsExpanded[array_rand($this->elementsExpanded)];
    }

    public function getBonus(): int
    {
        return $this->bonus;
    }
}
