<?php

namespace SlotMachine;

function printSlots(array $slots): void
{
    printf(
        trim(str_repeat(" %s", Game::NUMBER_OF_SLOTS)) . "\n",
        ...$slots
    );
}

function printStatusLine(Game $game)
{
    echo CLEAR_LINE;
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
