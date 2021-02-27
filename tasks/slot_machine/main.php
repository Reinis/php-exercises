<?php

declare(strict_types=1);

namespace SlotMachine;

require_once 'Game.php';
require_once 'Player.php';


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

    printf(
        "Prize: %4d bonus: %4d available: %4d\n",
        $prize,
        $game->getBonus(),
        $player->getAmount()
    );

    // Check for bonus games
    while ($game->getBonus() > 0) {
        // Autoplay five times bonus games
        $prize = 0;
        for ($i = 0; $i < Game::NUMBER_OF_BONUS_GAMES; $i++) {
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            $game->init();
            echo GO_TO_LINE_START . GO_FOUR_LINES_UP;
            sleep(1);

            $prize = $game->play(true);

            // Apply the multiplier
            $prize *= $bet / 10;
            $player->reward($prize);
            $bonus = $game->getBonus();

            echo CLEAR_LINE;
            printf(
                "Prize: %4d bonus: %4d available: %4d\n",
                $prize,
                $bonus,
                $player->getAmount()
            );
        }
    }
}
