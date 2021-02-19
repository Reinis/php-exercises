<?php declare(strict_types=1);

$board = [
    [' ', ' ', ' '],
    [' ', ' ', ' '],
    [' ', ' ', ' '],
];

$players = ['X', 'O'];

function displayBoard(array $board): void
{
    echo " {$board[0][0]} | {$board[0][1]} | {$board[0][2]} \n";
    echo "---+---+---\n";
    echo " {$board[1][0]} | {$board[1][1]} | {$board[1][2]} \n";
    echo "---+---+---\n";
    echo " {$board[2][0]} | {$board[2][1]} | {$board[2][2]} \n";
}

function checkBoard(array $board): int
{
    // Check rows
    foreach ($board as $row) {
        if (count(array_unique($row)) === 1) {
            if (end($row) === 'X') {
                return 0;
            } elseif (end($row) === 'O') {
                return 1;
            }
        }
    }

    // Check columns
    foreach (array_map(null, ...$board) as $column) {
        if (count(array_unique($column)) === 1) {
            if (end($column) === 'X') {
                return 0;
            } elseif (end($column) === 'O') {
                return 1;
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
                return 0;
            } elseif (end($diagonal) === 'O') {
                return 1;
            }
        }
    }

    // Check for tie
    if (!in_array(' ', array_merge(...$board))) {
        return 2;
    }

    // Game in progress
    return -1;
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
        case -1:
            // Next move
            $currentPlayer = abs($currentPlayer - 1);
            break;
        case 0:
        case 1:
            echo "The game was won by '{$players[$currentPlayer]}'.\n";
            exit(0);
        case 2:
            echo "The game is a tie.\n";
            exit(0);
        default:
            echo "Error: Invalid state!\n";
            exit(1);
    }
}
