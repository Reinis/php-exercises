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

function printStatusLine(Game $game)
{
    printf(
        "Prize: %4d bonus: %4d available: %4d\n",
        $game->getPrize(),
        $game->getBonus(),
        $game->getAmount()
    );
}

function initRolls(Game $game, bool $moveCursor = true): void
{
    if ($moveCursor) {
        echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
    }

    for ($i = 0; $i < Game::NUMBER_OF_SLOTS; $i++) {
        printSlots(
            array_fill(0, Game::NUMBER_OF_SLOTS, Game::PLACEHOLDER_ELEMENT)
        );
    }

    printStatusLine($game);
}

function displayRolls(Game $game): void
{
    $rolls = $game->getRolls();

    echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
    sleep(1);

    for ($j = 0; $j < Game::NUMBER_OF_SLOTS; $j++) {
        printSlots($rolls[$j]);
        sleep(1);
    }

    printStatusLine($game);
}


const DISABLE_CURSOR = "\e[?25l";
const ENABLE_CURSOR = "\e[?25h";
const GO_TO_LINE_START = "\r";
const GO_ONE_LINE_UP = "\e[1A";
const GO_FOUR_LINES_UP = "\e[4A";
const CLEAR_LINE = "\e[2K";


$game = new Game(new Player());

do {
    $amount = filter_var(
        readline('-> Start amount (min 10, step 10): '),
        FILTER_VALIDATE_INT
    );
} while ($amount === false || $amount < 10 || $amount % 10 !== 0);

$game->setAmount($amount);
initRolls($game, false);

while ($game->getAmount() >= 10 || $game->getBonus() !== 0) {
    if ($game->getBonus() === 0) {
        do {
            echo CLEAR_LINE . GO_TO_LINE_START;

            $bet = filter_var(
                readline("-> Bet: "),
                FILTER_VALIDATE_INT
            );

            echo GO_ONE_LINE_UP;
        } while ($bet === false || $bet < 10 || $bet % 10 !== 0);

        // Check available money
        if ($bet > $game->getAmount()) {
            echo CLEAR_LINE;
            echo "You don't have enough money for the bet!";
            sleep(2);
            continue;
        }

        $game->setBet($bet);
    }

    echo DISABLE_CURSOR;

    initRolls($game);

    $game->play($game->getBonus() > 0);

    displayRolls($game);

    echo ENABLE_CURSOR;
}
