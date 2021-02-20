<?php declare(strict_types=1);

const WORD_FILE_NAME = 'words_alpha.txt';

$validResponses = ['again', 'a', 'quit', 'q'];

$words = file(WORD_FILE_NAME, FILE_IGNORE_NEW_LINES);

if ($words === false) {
    echo 'Error: Could not read the word file: ' . WORD_FILE_NAME . PHP_EOL;
    exit(1);
}


class Game
{
    private const MAX_CONSECUTIVE_GUESSES = 5;

    private array $words;
    private string $word;
    private array $characters;
    private array $guessed = [];
    private array $misses = [];
    private int $repeatedMisses = 0;

    public function __construct(array $words)
    {
        $this->words = $words;
        $this->reset();
    }

    public function reset()
    {
        $this->word = $this->words[array_rand($this->words)];
        $this->makeTranslationTable();
        $this->guessed = [];
        $this->misses = [];
        $this->repeatedMisses = 0;
    }

    private function makeTranslationTable(): void
    {
        $this->characters = [];

        foreach (str_split($this->word) as $char) {
            $this->characters[$char] = ' _';
        }
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getTranslationTable(): array
    {
        return $this->characters;
    }

    public function getMisses(): array
    {
        return $this->misses;
    }

    public function haveGuessed(string $guess): bool
    {
        return in_array($guess, $this->guessed);
    }

    public function makeGuess(string $guess): void
    {
        $this->addGuessed($guess);

        if (preg_match('/' . $guess . '/', $this->word) === 1) {
            $this->updateTranslationTable($guess);
            $this->repeatedMisses = 0;
        } elseif (preg_match('/' . $guess . '/', $this->word) === 0) {
            $this->addMisses($guess);
            $this->repeatedMisses++;
        } else {
            echo "Error: Character match failed!\n";
            exit(1);
        }
    }

    private function addGuessed(string $guess): void
    {
        $this->guessed[] = $guess;
    }

    private function updateTranslationTable(string $char): void
    {
        $this->characters[$char] = " $char";
    }

    private function addMisses(string $miss): void
    {
        $this->misses[] = $miss;
    }

    public function status(): int
    {
        // The word is revealed
        if (!in_array(' _', array_values($this->characters))) {
            return 1;
        }

        // The game is lost
        if ($this->repeatedMisses >= self::MAX_CONSECUTIVE_GUESSES) {
            return 2;
        }

        // Game in progress
        return 0;
    }
}

// Set up the game
$game = new Game($words);

// Begin
while (true) {
    echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
    echo 'Word: ' . strtr($game->getWord(), $game->getTranslationTable()) . PHP_EOL;
    echo 'Misses: ' . implode($game->getMisses()) . PHP_EOL;

    // Check game termination conditions
    if ($game->status() > 0) {
        if ($game->status() === 2) {
            echo 'You lost! The word was: ' . $game->getWord() . PHP_EOL;
        } else {
            echo "YOU GOT IT!\n";
        }

        do {
            $response = trim(readline('Play "again" or "quit"? '));
        } while (!in_array($response, $validResponses));

        if ($response[0] === 'a') {
            $game->reset();
            continue;
        } else {
            break;
        }
    }

    do {
        $guess = trim(readline('Guess: '));
    } while (!ctype_lower($guess) or strlen($guess) !== 1 or $game->haveGuessed($guess));

    $game->makeGuess($guess);
}
