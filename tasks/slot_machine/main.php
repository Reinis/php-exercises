<?php

declare(strict_types=1);


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

class Player

{
    private int $amount = 0;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function deduct(int $amount): void
    {
        $this->amount -= $amount;
    }

    public function reward(int $amount): void
    {
        $this->amount += $amount;
    }
}

const DISABLE_CURSOR = "\e[?25l";
const ENABLE_CURSOR = "\e[?25h";
const GO_TO_LINE_START = "\r";
const GO_ONE_LINE_UP = "\e[1A";
const GO_FOUR_LINES_UP = "\e[4A";
const GO_FIVE_LINES_UP = "\e[5A";
const CLEAR_LINE = "\e[2K";

$player = new Player();
$game = new Game($player);

do {
    $amount = filter_var(
        readline('-> Start amount (min 10, step 10): '),
        FILTER_VALIDATE_INT
    );
} while ($amount === false || $amount < 10 || $amount % 10 !== 0);

$player->setAmount($amount);
$game->init();

while ($player->getAmount() >= 10) {

    do {
        echo CLEAR_LINE . ENABLE_CURSOR;
        $bet = filter_var(
            readline("-> Bet: "),
            FILTER_VALIDATE_INT);
    } while ($bet === false || $bet < 10 || $bet % 10 !== 0);


    // Check available money
    if ($bet > $player->getAmount()) {
        echo GO_ONE_LINE_UP . CLEAR_LINE;
        echo "You don't have enough money for the bet!\n";
        continue;
    }

    echo GO_TO_LINE_START . GO_FIVE_LINES_UP . DISABLE_CURSOR;

    // Deduct the bet
    $player->deduct($bet);

    $game->init();
    echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
    sleep(1);
    $prize = $game->play();

    // Apply the multiplier
    $prize *= $bet / 10;

    $player->reward($prize);

    printf("Prize: %4d\n", $prize);

    // Check for bonus games
    while ($game->getBonus() > 0) {
        // Autoplay five times bonus games
        $prize = 0;
        for ($i = 0; $i < Game::NUMBER_OF_BONUS_GAMES; $i++) {
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            $game->init();
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            sleep(1);
            $prize += $game->play(true);
            $bonus = $game->getBonus();
            echo CLEAR_LINE;
            printf("Prize: %4d bonus: %4d available: %4d\n", $prize, $bonus, $player->getAmount());
        }
    }
}
