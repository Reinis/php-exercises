<?php

declare(strict_types=1);

namespace SlotMachine;

require_once 'Game.php';
require_once 'Player.php';
require_once 'Functions.php';
require_once 'Constants.php';


$game = new Game(new Player());

do {
    $input = readline('-> Start amount (min 10, step 10): ');
    $amount = filter_var($input, FILTER_VALIDATE_INT);

    if ($input === 'q') {
        exit("Quitting. Good for you!\n");
    }

    if ($amount === false) {
        displayErrorMessage("Invalid amount!");
    } elseif ($amount < 10) {
        displayErrorMessage("Amount too small!");
    } elseif ($amount % 10 !== 0) {
        displayErrorMessage("Has to be a multiple of 10!");
    }
} while ($amount === false || $amount < 10 || $amount % 10 !== 0);

$game->setAmount($amount);
initRolls($game, false);

while ($game->getAmount() >= 0 || $game->getBonus() !== 0) {
    if ($game->getBonus() === 0) {
        do {
            echo CLEAR_LINE . GO_TO_LINE_START;

            $input = readline("-> Bet: ");
            $bet = filter_var($input, FILTER_VALIDATE_INT);

            if ($input === 'q') {
                exit("You receive " . $game->getAmount() . "!\n");
            }

            if ($bet === false) {
                displayErrorMessage("Invalid bet!");
            } elseif ($bet < 10) {
                displayErrorMessage("Bet too small!");
            } elseif ($bet % 10 !== 0) {
                displayErrorMessage("Bet has to be a multiple of 10!");
            }
        } while ($bet === false || $bet < 10 || $bet % 10 !== 0);

        // Check available money
        if ($bet > $game->getAmount()) {
            displayErrorMessage("You don't have enough money for the bet!");
            continue;
        }

        echo GO_ONE_LINE_UP;

        $game->setBet($bet);
    }

    echo DISABLE_CURSOR;

    initRolls($game);

    $game->play($game->getBonus() > 0);

    displayRolls($game);

    echo ENABLE_CURSOR;
}
