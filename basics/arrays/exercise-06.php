<?php declare(strict_types=1);

const WORD_FILE_NAME = 'words_alpha.txt';
const MAX_CONSECUTIVE_GUESSES = 5;

$validResponses = ['again', 'a', 'quit', 'q'];

$words = file(WORD_FILE_NAME, FILE_IGNORE_NEW_LINES);

if ($words === false) {
    echo 'Error: Could not read the word file: ' . WORD_FILE_NAME . PHP_EOL;
    exit(1);
}

function makeTranslationTable(string $word): array
{
    $characters = [];

    foreach (str_split($word) as $char) {
        $characters[$char] = ' _';
    }

    return $characters;
}

// Set up the game
$word = $words[array_rand($words)];
$word = $words[count($words) - 1];
$characters = makeTranslationTable($word);

$misses = [];
$guessed = [];
$repeatedMisses = 0;

// Begin
while (true) {
    echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
    echo 'Word: ' . strtr($word, $characters) . PHP_EOL;
    echo 'Misses: ' . implode($misses) . PHP_EOL;

    // Check game termination conditions
    if (!in_array(' _', array_values($characters)) or $repeatedMisses >= MAX_CONSECUTIVE_GUESSES) {
        if ($repeatedMisses >= MAX_CONSECUTIVE_GUESSES) {
            echo "You lost! The word was: {$word}\n";
            $repeatedMisses = 0;
        } else {
            echo "YOU GOT IT!\n";
        }

        do {
            $response = trim(readline('Play "again" or "quit"? '));
        } while (!in_array($response, $validResponses));

        if ($response[0] === 'a') {
            $word = $words[array_rand($words)];
            $characters = makeTranslationTable($word);

            $misses = [];
            $guessed = [];

            continue;
        } else {
            break;
        }
    }

    do {
        $guess = trim(readline('Guess: '));
    } while (!ctype_lower($guess) or strlen($guess) !== 1 or in_array($guess, $guessed));

    $guessed[] = $guess;

    if (preg_match('/' . $guess . '/', $word) === 1) {
        $characters[$guess] = " $guess";
        $repeatedMisses = 0;
    } elseif (preg_match('/' . $guess . '/', $word) === 0) {
        $misses[] = $guess;
        $repeatedMisses++;
    } else {
        echo "Error: Character match failed!\n";
        exit(1);
    }
}
