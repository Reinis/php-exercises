<?php

declare(strict_types=1);

namespace SlotMachine;

require_once 'Game.php';
require_once 'Player.php';
require_once 'Functions.php';
require_once 'Constants.php';


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
