<?php declare(strict_types=1);

$board = [
    [' ', ' ', ' '],
    [' ', ' ', ' '],
    [' ', ' ', ' '],
];

$players = ['X', 'O'];

const GAME_IN_PROGRESS = -1;
const GAME_WINNER_X = 0;
const GAME_WINNER_O = 1;
const GAME_IS_TIE = 2;

function displayBoard(array $board): void
{
    printf(" %s | %s | %s \n", ...$board[0]);
    printf("---+---+---\n");
    printf(" %s | %s | %s \n", ...$board[1]);
    printf("---+---+---\n");
    printf(" %s | %s | %s \n", ...$board[2]);
}

function checkBoard(array $board): int
{
    // Check rows
    foreach ($board as $row) {
        if (count(array_unique($row)) === 1) {
            if (end($row) === 'X') {
                return GAME_WINNER_X;
            } elseif (end($row) === 'O') {
                return GAME_WINNER_O;
            }
        }
    }

    // Check columns
    foreach (array_map(null, ...$board) as $column) {
        if (count(array_unique($column)) === 1) {
            if (end($column) === 'X') {
                return GAME_WINNER_X;
            } elseif (end($column) === 'O') {
                return GAME_WINNER_O;
            }
        }
    }

    // Check diagonals
    $diagonals = [
        [$board[0][0], $board[1][1], $board[2][2]],
        [$board[0][2], $board[1][1], $board[2][0]]
    ];

    foreach ($diagonals as $diagonal) {
        if (count(array_unique($diagonal)) === 1) {
            if (end($diagonal) === 'X') {
                return GAME_WINNER_X;
            } elseif (end($diagonal) === 'O') {
                return GAME_WINNER_O;
            }
        }
    }

    // Check for tie
    if (!in_array(' ', array_merge(...$board))) {
        return GAME_IS_TIE;
    }

    return GAME_IN_PROGRESS;
}

displayBoard($board);

$currentPlayer = 0;

while (true) {
    printf("'%s', choose your location (row, column): ", $players[$currentPlayer]);
    [$row, $column] = preg_split('/[\s,]+/', trim(readline()), 2);

    if (!ctype_digit($row) or !ctype_digit($column)) {
        echo "Error: Invalid input!\n";
        continue;
    }

    $row = (int)$row;
    $column = (int)$column;

    if ($row < 0 or $row > 2 or $column < 0 or $column > 2) {
        echo "Error: Location out of bounds!\n";
        continue;
    }

    if ($board[$row][$column] !== ' ') {
        echo "Error: Invalid move!\n";
        continue;
    }

    $board[$row][$column] = $players[$currentPlayer];

    displayBoard($board);

    switch (checkBoard($board)) {
        case GAME_IN_PROGRESS:
            // Next move
            $currentPlayer = abs($currentPlayer - 1);
            break;
        case GAME_WINNER_X:
        case GAME_WINNER_O:
            echo "The game was won by '{$players[$currentPlayer]}'.\n";
            exit(0);
        case GAME_IS_TIE:
            echo "The game is a tie.\n";
            exit(0);
        default:
            echo "Error: Invalid state!\n";
            exit(1);
    }
}
