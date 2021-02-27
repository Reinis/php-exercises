<?php

declare(strict_types=1);

namespace SlotMachine;

require_once 'Game.php';
require_once 'Player.php';


function printSlots(array $slots): void
{
    printf(
        trim(str_repeat(" %s", Game::NUMBER_OF_SLOTS)) . "\n",
        ...$slots
    );
}

function initRolls(Game $game): void
{
    for ($i = 0; $i < Game::NUMBER_OF_SLOTS; $i++) {
        printSlots(
            array_fill(0, Game::NUMBER_OF_SLOTS, Game::PLACEHOLDER_ELEMENT)
        );
    }

    printf(
        "Prize: %4d bonus: %4d available: %4d\n",
        $game->getPrize(),
        $game->getBonus(),
        $game->getAmount()
    );
}

function displayRolls(Game $game): void
{
    $rolls = $game->getRolls();

    for ($j = 0; $j < Game::NUMBER_OF_SLOTS; $j++) {
        printSlots($rolls[$j]);
        sleep(1);
    }
}


const DISABLE_CURSOR = "\e[?25l";
const ENABLE_CURSOR = "\e[?25h";
const GO_TO_LINE_START = "\r";
const GO_ONE_LINE_UP = "\e[1A";
const GO_FOUR_LINES_UP = "\e[4A";
const GO_FIVE_LINES_UP = "\e[5A";
const CLEAR_LINE = "\e[2K";


$game = new Game(new Player());

do {
    $amount = filter_var(
        readline('-> Start amount (min 10, step 10): '),
        FILTER_VALIDATE_INT
    );
} while ($amount === false || $amount < 10 || $amount % 10 !== 0);

$game->setAmount($amount);
initRolls($game);

while ($game->getAmount() >= 10) {
    do {
        echo CLEAR_LINE . GO_TO_LINE_START;
        $bet = filter_var(
            readline("-> Bet: "),
            FILTER_VALIDATE_INT
        );
    } while ($bet === false || $bet < 10 || $bet % 10 !== 0);

    // Check available money
    if ($bet > $game->getAmount()) {
        echo GO_ONE_LINE_UP . CLEAR_LINE;
        echo "You don't have enough money for the bet!";
        sleep(2);
        continue;
    }

    $game->setBet($bet);

    echo GO_TO_LINE_START . GO_FIVE_LINES_UP . DISABLE_CURSOR;

    initRolls($game);
    echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
    sleep(1);

    $game->play();

    displayRolls($game);

    printf(
        "Prize: %4d bonus: %4d available: %4d\n",
        $game->getPrize(),
        $game->getBonus(),
        $game->getAmount()
    );

    // Check for bonus games
    while ($game->getBonus() > 0) {
        // Autoplay bonus games
        for ($i = 0; $i < Game::NUMBER_OF_BONUS_GAMES; $i++) {
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            initRolls($game);
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            sleep(1);

            $game->play(true);

            displayRolls($game);

            echo CLEAR_LINE;
            printf(
                "Prize: %4d bonus: %4d available: %4d\n",
                $game->getPrize(),
                $game->getBonus(),
                $game->getAmount()
            );
        }
    }

    echo ENABLE_CURSOR;
}
